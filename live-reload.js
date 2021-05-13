var fs = require('fs');
var https = require('https');
var http = require('http');

var noSsl = process.argv[2] == 'undefined' ? false : (process.argv[2] == 'http' ? true : false );
var ssl = !noSsl;

var server;
if ( ssl ) {
    var svrOptions = {
        key: fs.readFileSync('tmp/ssl/live-reload/private.key'),
        cert: fs.readFileSync('tmp/ssl/live-reload/cert-ca-bundle.crt'),
    };
    server = https.createServer(svrOptions, function onRequest(req, res) {
        // Set CORS headers
        res.setHeader('Access-Control-Allow-Origin', '*')
        res.setHeader('Access-Control-Allow-Methods', 'OPTIONS, GET');
        if ( req.method === 'OPTIONS' ) {
            res.writeHead(200);
            res.end();
            return;
        }
        res.write("reload.js");
    });
    server.listen(12345);
} else {
    server = http.createServer(function onRequest(req, res) {
        // Set CORS headers
        res.setHeader('Access-Control-Allow-Origin', '*')
        res.setHeader('Access-Control-Allow-Methods', 'OPTIONS, GET');
        if ( req.method === 'OPTIONS' ) {
            res.writeHead(200);
            res.end();
            return;
        }
        res.write("reload.js");
    });
    server.listen(12345);
}


/// By pass - Cors problem
var io = require('socket.io')(server, {
    cors: {
        origin: "*",
        methods: ["GET", "POST"]
    }
});
io.on('connection', function (client) {
    client.on('event', function (data) {});
    client.on('disconnect', function () {});
});
var chokidar = require('chokidar');
chokidar.watch('.', { ignored: [ '.idea', 'etc/phpdoc', '.phpdoc', 'etc/sql', 'node_modules', 'etc/fontawesome-free-5', 'etc/fontawesome-pro-5', 'etc/phpThumb', 'tmp', 'var', 'files', '**/debug.log', '**/vendor', '**/scss', '**/.git', 'package*', 'hot-reload.js', '**/*.mp4', '**/*.mp3', '**/*.jpg', '**/*.png', '**/*.gif', 'etc/phpMyAdmin', 'docker'] } ).on('all', function (event, path) {
    console.log(event, path, ' at ' + ( new Date ).toLocaleString());
    io.emit('reload', { code: 'reload' });
});
