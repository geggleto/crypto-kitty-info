const helper = require('./rabbit/compare');

let kitties = helper.findMatchesForGeneration(0, "0x75771dedde9707fbb78d9f0dbdc8a4d4e7784794");

kitties.then(topMatches => {
  console.log(JSON.stringify(topMatches));
});