const Web3 = require('web3');

require('axios-debug-log')({
    request: function (debug, config) {
        console.log(config);
    },
    response: function (debug, response) {
    },
    error: function (debug, error) {
        // Read https://www.npmjs.com/package/axios#handling-errors for more info
        debug('Boom', error)
    }
});

const axios = require('axios');

const promisify = foo => new Promise((resolve, reject) => {
    foo((error, result) => {
        if (error) {
            reject(error);
        } else {
            resolve(result);
        }
    });
});


// set the provider you want from Web3.providers
let web3 = new Web3(new Web3.providers.HttpProvider('https://mainnet.infura.io/metamask'));
let getBlockNumber = () => promisify( callback =>  web3.eth.getBlockNumber(callback));

let getContract = (abi, address) => {
    return new web3.eth.Contract(abi, address);
};

const salesContractAddress = '0xb1690c08e213a35ed9bab7b318de14420fb57d8c';
const salesContractABI = [{"constant":false,"inputs":[{"name":"_tokenId","type":"uint256"},{"name":"_startingPrice","type":"uint256"},{"name":"_endingPrice","type":"uint256"},{"name":"_duration","type":"uint256"},{"name":"_seller","type":"address"}],"name":"createAuction","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[],"name":"unpause","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"_tokenId","type":"uint256"}],"name":"bid","outputs":[],"payable":true,"stateMutability":"payable","type":"function"},{"constant":true,"inputs":[{"name":"","type":"uint256"}],"name":"lastGen0SalePrices","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"paused","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[],"name":"withdrawBalance","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[{"name":"_tokenId","type":"uint256"}],"name":"getAuction","outputs":[{"name":"seller","type":"address"},{"name":"startingPrice","type":"uint256"},{"name":"endingPrice","type":"uint256"},{"name":"duration","type":"uint256"},{"name":"startedAt","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"ownerCut","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[],"name":"pause","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"isSaleClockAuction","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_tokenId","type":"uint256"}],"name":"cancelAuctionWhenPaused","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"gen0SaleCount","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"owner","outputs":[{"name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_tokenId","type":"uint256"}],"name":"cancelAuction","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[{"name":"_tokenId","type":"uint256"}],"name":"getCurrentPrice","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"nonFungibleContract","outputs":[{"name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"averageGen0SalePrice","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"newOwner","type":"address"}],"name":"transferOwnership","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"inputs":[{"name":"_nftAddr","type":"address"},{"name":"_cut","type":"uint256"}],"payable":false,"stateMutability":"nonpayable","type":"constructor"},{"anonymous":false,"inputs":[{"indexed":false,"name":"tokenId","type":"uint256"},{"indexed":false,"name":"startingPrice","type":"uint256"},{"indexed":false,"name":"endingPrice","type":"uint256"},{"indexed":false,"name":"duration","type":"uint256"}],"name":"AuctionCreated","type":"event"},{"anonymous":false,"inputs":[{"indexed":false,"name":"tokenId","type":"uint256"},{"indexed":false,"name":"totalPrice","type":"uint256"},{"indexed":false,"name":"winner","type":"address"}],"name":"AuctionSuccessful","type":"event"},{"anonymous":false,"inputs":[{"indexed":false,"name":"tokenId","type":"uint256"}],"name":"AuctionCancelled","type":"event"},{"anonymous":false,"inputs":[],"name":"Pause","type":"event"},{"anonymous":false,"inputs":[],"name":"Unpause","type":"event"}];

const salesContract = getContract(salesContractABI, salesContractAddress);

const getPastEvents = (event, filter) => promisify( callback => salesContract.getPastEvents(event, filter, callback));


// getBlockNumber().then( number => {
//    return axios.post('https://dna.cryptokittydata.info/insert/blockNumber')
//        .then(response => {
//            let blockNumber = response.data.blockNumber;
//            let ceilingBlockNumber = number - 240;
//            let incrementor = 50;
//
//            if (blockNumber == null) {
//                //Origin Block Number
//                blockNumber = 4605167;
//            }
//
//        })
// }).catch(err => console.log(err));

function pastAuctionSuccessfulEvents(from, to) {
    return getPastEvents('AuctionSuccessful', {
        fromBlock: from,
        toBlock: to
    });
}

function pastAuctionCreatedEvents(from, to) {
    return getPastEvents('AuctionCreated', {
        fromBlock: from,
        toBlock: to
    });
}

function pastAuctionCancelledEvents(from, to) {
    return getPastEvents('AuctionCancelled', {
        fromBlock: from,
        toBlock: to
    });
}

function thing(blockNumber, incrementor) {

    let from = blockNumber;
    let to = blockNumber + incrementor;

    let objects = [];


    return Promise.all([
        pastAuctionSuccessfulEvents(from, to),
        pastAuctionCreatedEvents(from, to),
        pastAuctionCancelledEvents(from, to)
    ]).then( results => {
        if (results[0].length > 0) {
            for (let i in results[0]) {
                let tx = results[0][i];

                let object = {
                    tx : tx.transactionHash,
                    blockNumber : tx.blockNumber,
                    event : tx.event,
                    tokenId : tx.returnValues.tokenId,
                    startingPrice : " ",
                    endingPrice : tx.returnValues.totalPrice,
                    duration : " ",
                    address : tx.returnValues.winner
                };

                objects.push(object);
            }
        }

        if (results[1].length > 0) {
            for (let i in results[1]) {
                let tx = results[1][i];

                let object = {
                    tx : tx.transactionHash,
                    blockNumber : tx.blockNumber,
                    event : tx.event,
                    tokenId : tx.returnValues.tokenId,
                    startingPrice : tx.returnValues.startingPrice,
                    endingPrice : tx.returnValues.endingPrice,
                    duration : tx.returnValues.duration,
                    address : " "
                };

                objects.push(object);

            }
        }

        if (results[2].length > 0) {
            for (let i in results[2]) {
                let tx = results[2][i];

                let object = {
                    tx : tx.transactionHash,
                    blockNumber : tx.blockNumber,
                    event : tx.event,
                    tokenId : tx.returnValues.tokenId,
                    startingPrice : "",
                    endingPrice : "",
                    duration : "",
                    address : ""
                };

                objects.push(object);
            }
        }

        return objects;
    });

}

// let object = {
//     tx : "1",
//     blockNumber : "2",
//     event : "3",
//     tokenId : "4",
//     startingPrice : "5",
//     endingPrice : "6",
//     duration : "7",
//     address : "8"
// };
//
// sendRequest(object);

thing(5605167, 500)
    .then(objects => {
        for (let i in objects) {
            console.log(objects[i]);

            sendRequest(objects[i]).then(response => {
                console.log(response);
            });

            return ;
        }
    });

async function sendRequest(object) {
    let result = await axios({
        method: 'post',
        url: "https://dna.cryptokittydata.info/insert/sale",
        data: object,
        headers: {'Content-Type': 'application/json'},
    });

    return result;
}