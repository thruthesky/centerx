
var fs = require('fs');
var https = require('https');
var svrOptions = {
    key: fs.readFileSync('tmp/ssl/philov.com/private.key'),
    cert: fs.readFileSync('tmp/ssl/philov.com/cert-ca-bundle.crt'),
};

var server = https.createServer(svrOptions, function onRequest(req, res) {
    // Set CORS headers
    res.setHeader('Access-Control-Allow-Origin', req.headers.origin)
    res.setHeader('Access-Control-Allow-Methods', 'OPTIONS, GET');
    if ( req.method === 'OPTIONS' ) {
        res.writeHead(200);
        res.end();
        return;
    }
    res.write("reload.js");
});
server.listen(12345);

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
chokidar.watch('.', { ignored: [ '.idea', 'node_modules', 'tmp', '**/debug.log', '**/vendor', '**/scss', '**/.git', 'package*', 'hot-reload.js', '**/*.mp4', '**/*.mp3', '**/*.jpg', 'etc/phpMyAdmin', 'docker'] } ).on('all', function (event, path) {
    console.log(event, path, ' at ' + ( new Date ).toLocaleString());
    io.emit('reload', { code: 'reload' });
});

