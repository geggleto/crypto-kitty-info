var app = new Vue({
    el: '#app',
    data: {
        page : 'connection',
        service : true,
        conn : null,
        profile : '',
        turn : false,
        signedIn : false,

        kitties : [],
        selectionPage : 0,
        selectionLimit : 10,
        selectionOffset: 0,
        loadingRemoteAsset : false,
        battleId : '',
        winner : '',
        selectedCat : 0,
        selectedKitty : {
            image   : 'https://bulma.io/images/placeholders/128x128.png',
            health  : 100,
            attack  : 10,
            defense : 10,
            heal    : 5,
            wins    : 0,
            losses  : 0,
            id : 0,
            skill1 : 'Basic Attack',
            skill2 : 'Power Attack',
            skill3 : 'Lick Paws',
            skill1tier : 1,
            skill2tier : 1,
            skill3tier : 1,
            maxhealth : 100
        },
        opponentKitty : {
            image   : 'https://bulma.io/images/placeholders/128x128.png',
            health  : '???',
            attack  : '???',
            defense : '???',
            heal    : '???',
            wins    : '???',
            losses  : '???',
            id : '???',
            skill1 : '???',
            skill2 : '???',
            skill3 : '???',
            skill1tier : '???',
            skill2tier : '???',
            skill3tier : '???',
            maxhealth : 100
        },
        battle_log : [

        ],
        last_msg : {}
    },
    methods: {
        skill1 : function () {
            //console.log("Using Skill 1");
            this.conn.send(JSON.stringify({
                command : "player.take.turn",
                skill : 1,
                battleId : app.battleId,
                address : app.profile,
                kittyId : app.selectedKitty.id
            }));
        },
        skill2 : function () {
            //console.log("Using Skill 2");
            this.conn.send(JSON.stringify({
                command : "player.take.turn",
                skill : 2,
                battleId : app.battleId,
                address : app.profile,
                kittyId : app.selectedKitty.id
            }));
        },
        skill3 : function () {
            //console.log("Using Skill 3");
            this.conn.send(JSON.stringify({
                command : "player.take.turn",
                skill : 3,
                battleId : app.battleId,
                address : app.profile,
                kittyId : app.selectedKitty.id
            }));
        },
        login : function () {
            var signer = web3.eth.defaultAccount || web3.eth.accounts[0];
            var original_message = "Crypto Kitty Battles!";
            var message = web3.toHex(original_message);
            var message_hash = web3.sha3(
                '\u0019Ethereum Signed Message:\n' +
                message.length.toString() +
                message
            );

            web3.personal.sign(message, signer, function(err, res) {
                if (err) console.error(err);

                app.signedIn = true;
                app.page = 'registration';
                app.loadingKitties();
            });
        },
        connect : function () {
            this.service = true;

            this.conn = new WebSocket('ws://dna.kitty.fyi:8080/battle');

            this.conn.onmessage = function (ev) {
                var msg = JSON.parse(ev.data);
                app.last_msg = msg;

                if (app.page === 'registration') {
                    if (msg.event === 'player.loaded.kitty') {
                        app.selectedKitty = msg.kitty;
                        app.selectedCat = msg.kitty.id;
                        app.loadingRemoteAsset = false;
                    }
                }

                if (app.page === 'queue') { // We are waiting in Queue
                    if (msg.event === 'battle.started') {
                        app.page = 'battle';

                        app.battleId = msg.uuid;

                        if (msg.player1.kittyId === app.selectedCat) {
                            app.selectedKitty = msg.kitty1;
                            app.opponentKitty = msg.kitty2;
                        } else {
                            app.selectedKitty = msg.kitty2;
                            app.opponentKitty = msg.kitty1;
                        }

                        app.battle_log.unshift("Battle Started!");
                        app.battle_log.unshift("Kitty #" + msg.turn + " has first move!");

                        app.turn = (msg.turn === app.selectedCat);
                    }
                }

                if (app.page === 'battle') { // We are in Battle
                    if (msg.event === 'battle.action') {
                        app.battle_log.unshift(msg.message);
                    }

                    if (msg.event === 'battle.updated') {
                        //Load the state
                        if (msg.kitty1.id === app.selectedKitty.id) {
                            app.selectedKitty = msg.kitty1;
                            app.opponentKitty = msg.kitty2;
                        } else {
                            app.selectedKitty = msg.kitty2;
                            app.opponentKitty = msg.kitty1;
                        }

                        app.battle_log.unshift("Kitty #" + msg.turn + "'s move");

                        if (msg.turn === app.selectedKitty.id) {
                            app.turn = true;
                        } else {
                            app.turn = false;
                        }

                    }

                    if (msg.event === 'battle.ended') {
                        app.winner = msg.winner;

                        app.page = 'results';
                    }
                }
            };

            this.conn.onopen = function (ev) {

            };

            this.conn.onerror = function (ev) {
                app.service = false;
                app.page = 'connection';
                app.profile = '';
                app.signedIn = false;
            };

            this.conn.onclose = function (ev) {
                if (ev.code !== 3001) {
                    app.profile = '';
                    app.service = false;
                    app.page = 'connection';
                    app.signedIn = false;
                }
            };
        },
        loadingKitties : function () {

            this.loadingRemoteAsset = true;

            var kittiesUrl = 'https://api.cryptokitties.co/kitties?limit='+this.selectionLimit+'&owner_wallet_address='+this.profile+'&offset='+this.selectionOffset;

            $.get(kittiesUrl, function (res) {
                console.log(res);

                for (i in res.kitties) {
                    app.kitties.push(res.kitties[i]);
                }

                app.loadingRemoteAsset = false;
            });
        },
        selectKitty : function (index) {

            //make request

            this.loadingRemoteAsset = true;

            this.conn.send(JSON.stringify({
                command : "player.load.kitty",
                kittyId : app.kitties[index].id
            }));

            // this.selectedKitty.image = this.kitties[index].image_url_cdn;
            // this.selectedKitty.id = this.kitties[index].id;
            // this.selectedCat = this.kitties[index].id;
        },

        deselectKitty : function (index) {
            this.selectedKitty.image = 'https://bulma.io/images/placeholders/128x128.png';
            this.selectedKitty.id = 0;
            this.selectedCat = 0;
        },

        enterBattle : function () {
            this.page = 'queue';
            this.battle_log = [];

            this.conn.send(JSON.stringify({
                command : "enter.queue",
                address : this.profile,
                kittyId : this.selectedCat
            }));
        },
        resetBattle : function () {
            this.page = 'registration';
            this.battleId = '';
            this.winner = '';
            this.selectedCat = 0;
            this.selectedKitty = {
                image   : 'https://bulma.io/images/placeholders/128x128.png',
                health  : 100,
                attack  : 10,
                defense : 10,
                heal    : 5,
                wins    : 0,
                losses  : 0,
                id : 0,
                skill1 : 'Basic Attack',
                skill2 : 'Power Attack',
                skill3 : 'Lick Paws',
                skill1tier : 1,
                skill2tier : 1,
                skill3tier : 1,
                maxhealth : 100
            };
            this.opponentKitty = {
                image   : 'https://bulma.io/images/placeholders/128x128.png',
                health  : '???',
                attack  : '???',
                defense : '???',
                heal    : '???',
                wins    : '???',
                losses  : '???',
                id : '???',
                skill1 : '???',
                skill2 : '???',
                skill3 : '???',
                skill1tier : '???',
                skill2tier : '???',
                skill3tier : '???',
                maxhealth : 100
            };
            this.battle_log = [];
            this.last_msg = {};
        }
    },
    mounted : function () {
        this.connect();

        this.$nextTick(function () {
            if (typeof web3 !== 'undefined') {
                this.profile = web3.eth.accounts[0];
            }
        });

    },
    delimiters : ["<%", "%>"]
});