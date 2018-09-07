const Web3 = require('web3');

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

getBlockNumber().then( number => {
   console.log(number)
}).catch(err => console.log(err));