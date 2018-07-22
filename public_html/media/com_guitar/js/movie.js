var request = require('request');
request(
    'http://www.omdbapi.com/?t=harry&y=2013&plot=full',
    function (error, response, body) {
        if (!error && response.statusCode === 200) {
            res.send(body);
            // var parsedData = JSON.parse(body);
            // console.log(parsedData);
        }
    });