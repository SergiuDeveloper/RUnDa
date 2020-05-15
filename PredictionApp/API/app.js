'use strict'

const http = require('http')
const mysql = require('sync-mysql')
const crypto = require('crypto')
const fs = require('fs')

const httpServer = http.createServer((request, response) => {
    let requestBody = '';

    request.on('data', (dataChunk) => {
        requestBody += dataChunk.toString();
    });
    request.on('end', () => {
        if (typeof endpointsDictionary[request.method] === 'undefined' || typeof endpointsDictionary[request.method][request.url] === 'undefined') {
            response.writeHead(404)
            response.end()
            return
        }
        
        let statusCode = 200
        try {
            statusCode = endpointsDictionary[request.method][request.url](JSON.parse(requestBody))
        }
        catch (exception) {
            console.error(exception)
            statusCode = 500
        }

        response.writeHead(statusCode)
        response.end()
    });
})

httpServer.listen(80)

const endpointsDictionary = {
    'POST': {
        '/UpdateTrainingResults': updateTrainingResults
    }
}

function updateTrainingResults(requestObject) {
    const authenticationKey = requestObject.AuthenticationKey
    const trainingResultsJSONObject = requestObject.TrainingResults

    const databaseConnection = new mysql({
        host:       'predictionapp.mysql.database.azure.com',
        user:       'prediction_app@predictionapp',
        password:   'admin_pass123',
        database:   'PredictionApp'
    });

    const dbAuthenticationKeyRows = databaseConnection.query('SELECT COUNT(*) as rowCount FROM Authentication_Keys WHERE Authentication_Key = ?', [authenticationKey])
    if (dbAuthenticationKeyRows[0].rowCount === 0) {
        databaseConnection.dispose()
        return 401
    }

    if (!fs.existsSync('JSON'))
        fs.mkdirSync('JSON')
    fs.writeFileSync('JSON/training_results.json', JSON.stringify(trainingResultsJSONObject, null, 4))

    const newAuthenticationKey = crypto.randomBytes(32).toString('hex');
    databaseConnection.query('UPDATE Authentication_Keys SET Authentication_Key = ? WHERE Authentication_Key = ?', [newAuthenticationKey, authenticationKey])
    databaseConnection.dispose()

    return 200
}