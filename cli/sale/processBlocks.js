const amqp = require('amqplib/callback_api');
const app = require('./rabbit/util');

amqp.connect('amqp://ck_sales:ck_sales@198.211.101.215', function(err, conn) {
  if (err) {
    console.error(err);
    return ;
  }

  conn.createChannel(function(err, ch) {
    let q = 'sale_import';

    ch.assertQueue(q, {durable: true, 'x-dead-letter-exchange': `${q}_dlx`});

    app.getBlockNumber().then(BlockNumber => {

      let insertedBlockNumber = app.getLastInsertedBlock();

      let CurrentBlockNumber = 4605169;

      if (insertedBlockNumber) {
        CurrentBlockNumber = insertedBlockNumber;
      }
      const Incrementer = 1000;

      do {
        ch.sendToQueue(q, new Buffer(JSON.stringify({
          event : 'AuctionCreated',
          fromBlock : CurrentBlockNumber,
          toBlock : CurrentBlockNumber + Incrementer
        })), {persistent: true});

        CurrentBlockNumber += Incrementer + 1;
      } while(CurrentBlockNumber < BlockNumber - 1000);

    }).then(() => {
      /** This is an absolute hack b/c the lib wasn't written well */
      setTimeout(function() { conn.close(); process.exit(0) }, 500);
    });
  });

});
