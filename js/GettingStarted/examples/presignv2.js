AWS = require('aws-sdk');
request = require('request');
md5hex  = require('md5hex');
string  = require('string');

AWS.config.update({
	region: 'ru-msk',
	endpoint: 'http://hitbox.local',
});

var s3 = new AWS.S3({
	signatureVersion: 'v2'
});

var params = {Bucket: 'marabu', Key: 'excalibur/items/stark.jpg', Expires: 300};
var url = s3.getSignedUrl('putObject', params);
console.log(url);

var options = {
	method: "OPTIONS",
	url: url,
	headers: {
		'origin': 'mail.ru',
		'access-control-request-method':"PUT",
	}
};

request(options, function (error, response, body) {
	console.log(response.statusCode) // 200
	console.log(response.headers['content-type']) // 'image/png'
});

var content = "content";
var etag    = md5hex(content);
var put = {
	method: "PUT",
	url: url,
	body: content,
	headers: {
		'etag': "\"" + etag + "\"",
		'content-length': content.length,
	}
};

request(put, function (error, response, body) {
	console.log(response.statusCode) // 200
	console.log(response.headers['content-type']) // 'image/png'
});

