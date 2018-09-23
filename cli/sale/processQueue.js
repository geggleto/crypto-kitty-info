const amqp = require('amqplib/callback_api');
const app = require('./rabbit/util');

let getConnection = (url) => { return app.promisify(callback => amqp.connect(url), callback) };

getConnection('amqp://ck_sales:ck_sales@198.211.101.215').then( (conn) => {
  let getChannel = () => { return app.promisify(callback => conn.createChannel(callback)) } ;

  Promise.all([
    getChannel(),
    getChannel()
  ]).then(([ch1, ch2]) => {
    let incoming = 'sale_import';
    let outgoing = 'sale_created';

    ch1.assertQueue(incoming, {durable: true});
    ch2.assertQueue(outgoing, {durable: true});

    console.log(" [*] Waiting for messages in %s. To exit press CTRL+C", q);
    ch1.consume(incoming, function (msg) {
      let event = JSON.parse(msg.content.toString());

      app.getPastEvents(event.event, event.fromBlock, event.toBlock)
        .then( (events) => {

          let objects = [];

          for (let i in events) {
            let tx = events[i];

            let object = {
              tx: tx.transactionHash || "",
              blockNumber: tx.blockNumber || "",
              event: tx.event || "",
              tokenId: tx.returnValues.tokenId || "",
              startingPrice: tx.returnValues.startingPrice || "",
              endingPrice: tx.returnValues.endingPrice || "",
              duration: tx.returnValues.duration || "",
              address: tx.returnValues.address || "",
            };
            objects.push(object);
          }

          return app.insertEvents(objects).then(() => {
            ch1.ack();
          }).catch(() => {
            ch1.nack()
          });
        }).catch( () => {
          ch1.nack(msg);
        })

    }, {noAck: false});

  });
});