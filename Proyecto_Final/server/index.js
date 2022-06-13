const { SocketAddress } = require('net');

const port = 3000;

let express = require('express'),
    app = express(),
    http = require('http').Server(app),
    mongodb = require('mongodb').MongoClient,
    url = 'mongodb://localhost:27017',
    dbName = 'proyecto_final',
    socketio = require('socket.io')(http, {
        allowEIO3: true,
        cors: {
            origin: ['http://localhost:8000', 'http://127.0.0.1:8000'],
            credentials: true
        }
    });

socketio.on('connect', socket => {
    console.log('Conectado desde socket.io');
    socket.on('ubicacion', data => {
        data.contactos.forEach(contacto => {
            console.log(contacto);
            socketio.emit(''+ contacto.id, {
                titulo: data.lang == 'es' ? data.user.name + ' te ha enviado su ubicación' : data.user.name + ' has send you his location',
                mensaje: data.lang == 'es' ? 'Ubicación: ' + data.nombre : 'Location: ' + data.nombre,
            });
        });
    });
    socket.on('sendMsg', data => {
        mongodb.connect(url, (err, client) => {
            if (err) console.log(err);
            const db = client.db(dbName);
            db.collection('chats').insertOne({
                by: data.by,
                to: data.to,
                msg: data.msg,
                date: data.date
            }).then(response => {
                
            }).catch(error => {
                console.log(error);
            }); 
        });
    });
    socket.on('chats', data => {
        // mongodb.connect(url, (err, client) => {
        //     console.log(data, typeof data);
        //     if (err) console.log(err);
        //     const db = client.db(dbName);
        //     db.collection('chats').find({
        //         $or: [
        //             {by: data.ids[0], to: data.ids[1]},
        //             {by: data.ids[1], to: data.ids[0]}
        //         ]
        //     }).toArray((err, chat) => {
        //         if (err) console.log(err);
        //         console.log(`${data.ids.join('_')}Chat`);
        //         socket.emit(`${data.ids.join('_')}Chat`, chat);
        //     });
        // });
    });

});

app.use(express.json());
http.listen(port, function() {
    console.log('listening on http://127.0.0.1:' + port);
});