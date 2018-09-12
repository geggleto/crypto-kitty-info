// parity server
// parity --jsonrpc-interface="178.128.156.99" --jsonrpc-hosts="all" --jsonrpc-cors="all"

const Web3 = require('web3');

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

const timeout = ms => new Promise(res => setTimeout(res, ms))


// set the provider you want from Web3.providers
let web3 = new Web3(new Web3.providers.HttpProvider('https://mainnet.infura.io/metamask'));


let getBlockNumber = () => { return promisify(callback => web3.eth.getBlockNumber(callback)); };

let getContract = (abi, address) => {
    return new web3.eth.Contract(abi, address);
};

const salesContractAddress = '0xb1690c08e213a35ed9bab7b318de14420fb57d8c';
const salesContractABI = [{
    "constant": false,
    "inputs": [{"name": "_tokenId", "type": "uint256"}, {
        "name": "_startingPrice",
        "type": "uint256"
    }, {"name": "_endingPrice", "type": "uint256"}, {"name": "_duration", "type": "uint256"}, {
        "name": "_seller",
        "type": "address"
    }],
    "name": "createAuction",
    "outputs": [],
    "payable": false,
    "stateMutability": "nonpayable",
    "type": "function"
}, {
    "constant": false,
    "inputs": [],
    "name": "unpause",
    "outputs": [{"name": "", "type": "bool"}],
    "payable": false,
    "stateMutability": "nonpayable",
    "type": "function"
}, {
    "constant": false,
    "inputs": [{"name": "_tokenId", "type": "uint256"}],
    "name": "bid",
    "outputs": [],
    "payable": true,
    "stateMutability": "payable",
    "type": "function"
}, {
    "constant": true,
    "inputs": [{"name": "", "type": "uint256"}],
    "name": "lastGen0SalePrices",
    "outputs": [{"name": "", "type": "uint256"}],
    "payable": false,
    "stateMutability": "view",
    "type": "function"
}, {
    "constant": true,
    "inputs": [],
    "name": "paused",
    "outputs": [{"name": "", "type": "bool"}],
    "payable": false,
    "stateMutability": "view",
    "type": "function"
}, {
    "constant": false,
    "inputs": [],
    "name": "withdrawBalance",
    "outputs": [],
    "payable": false,
    "stateMutability": "nonpayable",
    "type": "function"
}, {
    "constant": true,
    "inputs": [{"name": "_tokenId", "type": "uint256"}],
    "name": "getAuction",
    "outputs": [{"name": "seller", "type": "address"}, {
        "name": "startingPrice",
        "type": "uint256"
    }, {"name": "endingPrice", "type": "uint256"}, {"name": "duration", "type": "uint256"}, {
        "name": "startedAt",
        "type": "uint256"
    }],
    "payable": false,
    "stateMutability": "view",
    "type": "function"
}, {
    "constant": true,
    "inputs": [],
    "name": "ownerCut",
    "outputs": [{"name": "", "type": "uint256"}],
    "payable": false,
    "stateMutability": "view",
    "type": "function"
}, {
    "constant": false,
    "inputs": [],
    "name": "pause",
    "outputs": [{"name": "", "type": "bool"}],
    "payable": false,
    "stateMutability": "nonpayable",
    "type": "function"
}, {
    "constant": true,
    "inputs": [],
    "name": "isSaleClockAuction",
    "outputs": [{"name": "", "type": "bool"}],
    "payable": false,
    "stateMutability": "view",
    "type": "function"
}, {
    "constant": false,
    "inputs": [{"name": "_tokenId", "type": "uint256"}],
    "name": "cancelAuctionWhenPaused",
    "outputs": [],
    "payable": false,
    "stateMutability": "nonpayable",
    "type": "function"
}, {
    "constant": true,
    "inputs": [],
    "name": "gen0SaleCount",
    "outputs": [{"name": "", "type": "uint256"}],
    "payable": false,
    "stateMutability": "view",
    "type": "function"
}, {
    "constant": true,
    "inputs": [],
    "name": "owner",
    "outputs": [{"name": "", "type": "address"}],
    "payable": false,
    "stateMutability": "view",
    "type": "function"
}, {
    "constant": false,
    "inputs": [{"name": "_tokenId", "type": "uint256"}],
    "name": "cancelAuction",
    "outputs": [],
    "payable": false,
    "stateMutability": "nonpayable",
    "type": "function"
}, {
    "constant": true,
    "inputs": [{"name": "_tokenId", "type": "uint256"}],
    "name": "getCurrentPrice",
    "outputs": [{"name": "", "type": "uint256"}],
    "payable": false,
    "stateMutability": "view",
    "type": "function"
}, {
    "constant": true,
    "inputs": [],
    "name": "nonFungibleContract",
    "outputs": [{"name": "", "type": "address"}],
    "payable": false,
    "stateMutability": "view",
    "type": "function"
}, {
    "constant": true,
    "inputs": [],
    "name": "averageGen0SalePrice",
    "outputs": [{"name": "", "type": "uint256"}],
    "payable": false,
    "stateMutability": "view",
    "type": "function"
}, {
    "constant": false,
    "inputs": [{"name": "newOwner", "type": "address"}],
    "name": "transferOwnership",
    "outputs": [],
    "payable": false,
    "stateMutability": "nonpayable",
    "type": "function"
}, {
    "inputs": [{"name": "_nftAddr", "type": "address"}, {"name": "_cut", "type": "uint256"}],
    "payable": false,
    "stateMutability": "nonpayable",
    "type": "constructor"
}, {
    "anonymous": false,
    "inputs": [{"indexed": false, "name": "tokenId", "type": "uint256"}, {
        "indexed": false,
        "name": "startingPrice",
        "type": "uint256"
    }, {"indexed": false, "name": "endingPrice", "type": "uint256"}, {
        "indexed": false,
        "name": "duration",
        "type": "uint256"
    }],
    "name": "AuctionCreated",
    "type": "event"
}, {
    "anonymous": false,
    "inputs": [{"indexed": false, "name": "tokenId", "type": "uint256"}, {
        "indexed": false,
        "name": "totalPrice",
        "type": "uint256"
    }, {"indexed": false, "name": "winner", "type": "address"}],
    "name": "AuctionSuccessful",
    "type": "event"
}, {
    "anonymous": false,
    "inputs": [{"indexed": false, "name": "tokenId", "type": "uint256"}],
    "name": "AuctionCancelled",
    "type": "event"
}, {"anonymous": false, "inputs": [], "name": "Pause", "type": "event"}, {
    "anonymous": false,
    "inputs": [],
    "name": "Unpause",
    "type": "event"
}];

const salesContract = getContract(salesContractABI, salesContractAddress);

const getPastEvents = (event, filter) => promisify(callback => salesContract.getPastEvents(event, filter, callback));

let StartBlock = 4605169;
let Incrementer = 10000;

getBlockNumber().then(blockNumber => {
  console.log(StartBlock);
  console.log(Incrementer);
  console.log(blockNumber);

  return getPastEvents('AuctionCreated', {
    fromBlock : StartBlock,
    toBlock : StartBlock + Incrementer
  }).then(events => {
      console.log("grab events");
      console.log(events.length);
  }).catch(err => {
      console.log("error");
      console.error(err);
  })

});


//
// getBlockNumber().then(number => {
//     return axios.post('https://dna.cryptokittydata.info/insert/blockNumber')
//         .then(response => {
//             // let blockNumber = response.data.blockNumber;
//             // let ceilingBlockNumber = parseInt(number) - 240;
//             // let incrementor = 1;
//
//             let blockNumber = number - 240;
//             let round = 4;
//             let window = 24000;
//             let to = blockNumber - window * ( round - 1);
//             let from = to - window*round;
//
//
//             console.log(from + "|" + to);
//
//             getEventsForSaleContract(from, to).then(async results => {
//
//                 if (results[0].length > 0) {
//                     for (let i in results[0]) {
//                         let objects = results[0][i];
//                         await sendRequest(objects);
//                     }
//                 }
//
//                 if (results[1].length > 0) {
//                     for (let i in results[1]) {
//                         let objects = results[1][i];
//                         await sendRequest(objects);
//                     }
//                 }
//
//                 if (results[2].length > 0) {
//                     for (let i in results[2]) {
//                         let objects = results[2][i];
//                         await sendRequest(objects);
//                     }
//                 }
//             });
//         })
// }).catch(err => console.log(err));
//
// function pastAuctionSuccessfulEvents(from, to) {
//     console.log("Attempting to ping Contract for Success");
//
//     return getPastEvents('AuctionSuccessful', {
//         fromBlock: from,
//         toBlock: to
//     });
// }
//
// function pastAuctionCreatedEvents(from, to) {
//     console.log("Attempting to ping Contract for Created");
//
//     return getPastEvents('AuctionCreated', {
//         fromBlock: from,
//         toBlock: to
//     });
// }
//
// function pastAuctionCancelledEvents(from, to) {
//     console.log("Attempting to ping Contract for Cancelled");
//
//     return getPastEvents('AuctionCancelled', {
//         fromBlock: from,
//         toBlock: to
//     });
// }
//
// function getEventsForSaleContract(blockNumber, incrementor) {
//
//     let from = blockNumber;
//     let to = blockNumber + incrementor;
//
//     return Promise.all([
//         pastAuctionSuccessfulEvents(from, to).then(results => {
//             let objects = [];
//             console.log('Getting Success Events');
//
//             for (let i in results) {
//                 let tx = results[i];
//
//                 let object = {
//                     tx: tx.transactionHash,
//                     blockNumber: tx.blockNumber,
//                     event: tx.event,
//                     tokenId: tx.returnValues.tokenId,
//                     startingPrice: " ",
//                     endingPrice: tx.returnValues.totalPrice,
//                     duration: " ",
//                     address: tx.returnValues.winner
//                 };
//
//                 objects.push(object);
//             }
//
//             return objects;
//         }),
//         pastAuctionCreatedEvents(from, to)
//             .then(results => {
//                 let objects = [];
//                 console.log('Getting Created Events');
//                 for (let i in results) {
//                     let tx = results[i];
//
//                     let object = {
//                         tx: tx.transactionHash,
//                         blockNumber: tx.blockNumber,
//                         event: tx.event,
//                         tokenId: tx.returnValues.tokenId,
//                         startingPrice: tx.returnValues.startingPrice,
//                         endingPrice: tx.returnValues.endingPrice,
//                         duration: tx.returnValues.duration,
//                         address: " "
//                     };
//                     objects.push(object);
//                 }
//
//
//                 return objects;
//             }),
//         pastAuctionCancelledEvents(from, to)
//             .then(results => {
//                 let objects = [];
//                 console.log('Getting Cancel Events');
//
//                 for (let i in results) {
//                     let tx = results[i];
//
//                     let object = {
//                         tx: tx.transactionHash,
//                         blockNumber: tx.blockNumber,
//                         event: tx.event,
//                         tokenId: tx.returnValues.tokenId,
//                         startingPrice: "",
//                         endingPrice: "",
//                         duration: "",
//                         address: ""
//                     };
//
//                     objects.push(object);
//                 }
//                 return objects;
//             })
//     ]);
// }
//
// async function sendRequest(object) {
//     return await axios({
//         method: 'post',
//         url: "https://dna.cryptokittydata.info/insert/sale",
//         data: object,
//         headers: {'Content-Type': 'application/json'},
//     });
// }
