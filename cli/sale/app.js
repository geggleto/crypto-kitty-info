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

let currentBlock = 4605169;
let Incrementer = 10000;

getBlockNumber().then(async blockNumber => {
  console.log(currentBlock);
  console.log(Incrementer);
  console.log(blockNumber);




  do {
    console.log(currentBlock);

    let events = await getPastEvents('AuctionCreated', {
      fromBlock: currentBlock,
      toBlock: currentBlock + Incrementer
    }).then(results => {

      let objects = [];

      for (let i in results) {
        let tx = results[i];

        let object = {
          tx: tx.transactionHash,
          blockNumber: tx.blockNumber,
          event: tx.event,
          tokenId: tx.returnValues.tokenId,
          startingPrice: tx.returnValues.startingPrice,
          endingPrice: tx.returnValues.endingPrice,
          duration: tx.returnValues.duration,
          address: ""
        };
        objects.push(object);
      }

      return { items : objects };
    }).catch(err => {
      console.log("error");
      console.error(err);

      return { items : [] };
    }).then(async objects => {
      return await sendRequest(objects).catch(err => { console.error(err); return { items : [] }; });
    });

    currentBlock += Incrementer + 1;

    await sleep(10000);

  } while (currentBlock <= blockNumber);
});

async function sendRequest(objects) {
  return await axios({
    method: 'post',
    url: "https://dna.cryptokittydata.info/insert/sales",
    data: objects,
    headers: {'Content-Type': 'application/json'},
  });
}

function sleep(ms){
  return new Promise(resolve=>{
    setTimeout(resolve,ms)
  })
}