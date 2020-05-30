'use strict'

const http = require('http')
const url = require('url')
const mysql = require('sync-mysql')
const crypto = require('crypto')
const fs = require('fs')

var trainingResultsJSONObject = null

if (!fs.existsSync('JSON'))
    fs.mkdirSync('JSON')
if (fs.existsSync('JSON/training_results.json'))
    trainingResultsJSONObject = JSON.parse(fs.readFileSync('JSON/training_results.json'))

const httpServer = http.createServer(async (request, response) => {
    let requestBody = ''

    request.on('data', (dataChunk) => {
        requestBody += dataChunk.toString()
    })
    request.on('end', () => {
        let urlParts = url.parse(request.url, true)

        if (!(request.method in endpointsDictionary) || !(urlParts.pathname in endpointsDictionary[request.method])) {
            response.writeHead(404)
            response.end()
            return
        }
        
        let serviceReturnValue = {
            'StatusCode': 500,
            'ResponseBody': ''
        }
        try {
            serviceReturnValue = endpointsDictionary[request.method][urlParts.pathname](
                urlParts.query,
                requestBody === '' ? null : JSON.parse(requestBody),
                response
            )
        }
        catch (exception) {
            console.error(exception)
            serviceReturnValue['StatusCode'] = 500
            serviceReturnValue['ResponseBody'] = ''
        }

        response.writeHead(serviceReturnValue['StatusCode'])
        response.write(serviceReturnValue['ResponseBody'])
        response.end()
    })
})

httpServer.listen(80, () => {
    console.log(`Server running on port ${httpServer.address().port}`)
})

const endpointsDictionary = {
    'GET': {
        '/RetrieveDataCategories': retrieveDataCategories,
        '/RetrieveData': retrieveData
    },
    'POST': {
        '/UpdateTrainingResults': updateTrainingResults
    }
}

function retrieveDataCategories(requestParametersObject, requestBodyObject, response) {
    if (trainingResultsJSONObject === null)
        return {
            'StatusCode': 204,
            'ResponseBody': ''
        }

    let dataAttributesObject = {
        'DataAttributes': {}
    }
    for (let categoryKey of Object.keys(trainingResultsJSONObject)) {
        if (!(categoryKey in dataAttributesObject['DataAttributes']))
            dataAttributesObject['DataAttributes'][categoryKey] = {} 
        for (let subcategoryKey of Object.keys(trainingResultsJSONObject[categoryKey])) {
            if (!(subcategoryKey in dataAttributesObject['DataAttributes'][categoryKey]))
                dataAttributesObject['DataAttributes'][categoryKey][subcategoryKey] = {}
            for (let locationKey of Object.keys(trainingResultsJSONObject[categoryKey][subcategoryKey])) {
                if (!(locationKey in dataAttributesObject['DataAttributes'][categoryKey][subcategoryKey]))
                    dataAttributesObject['DataAttributes'][categoryKey][subcategoryKey][locationKey] = Object.keys(trainingResultsJSONObject[categoryKey][subcategoryKey][locationKey])
            }
        }
    }

    return {
        'StatusCode': 200,
        'ResponseBody': JSON.stringify(dataAttributesObject, null, 4)
    }
}

function retrieveData(requestParametersObject, requestBodyObject, response) {
    if (trainingResultsJSONObject === null)
        return {
            'StatusCode': 204,
            'ResponseBody': ''
        }

    let category = requestParametersObject.Category
    let subcategory = requestParametersObject.Subcategory
    let location = requestParametersObject.Location
    let regressionType = requestParametersObject.RegressionType

    if (category === undefined || subcategory === undefined || location === undefined)
        return {
            'StatusCode': 400,
            'ResponseBody': ''
        }

    if (
        !(category in trainingResultsJSONObject) ||
        !(subcategory in trainingResultsJSONObject[category]) ||
        !(location in trainingResultsJSONObject[category][subcategory])
    )
        return {
            'StatusCode': 400,
            'ResponseBody': ''
        }

    if (regressionType === undefined) {
        let responseJSON = JSON.stringify(
            {
                'Data': trainingResultsJSONObject[category][subcategory][location]
            },
            null, 4
        )

        return {
            'StatusCode': 200,
            'ResponseBody': JSON.stringify(
                {
                    'Data': trainingResultsJSONObject[category][subcategory][location]
                },
                null, 4
            )
        }
    }

    if (!(regressionType in trainingResultsJSONObject[category][subcategory][location]))
        return {
            'StatusCode': 400,
            'ResponseBody': ''
        }


    return {
        'StatusCode': 200,
        'ResponseBody': JSON.stringify(
            {
                'Data': trainingResultsJSONObject[category][subcategory][location][regressionType]
            },
            null, 4
        )
    }
}

function updateTrainingResults(requestParametersObject, requestBodyObject, response) {
    if (requestBodyObject === null)
        return {
            'StatusCode': 400,
            'ResponseBody': ''
        }

    const authenticationKey = requestBodyObject.AuthenticationKey
    const newTrainingResultsJSONObject = requestBodyObject.TrainingResults

    const databaseConnection = new mysql({
        host:       'predictionapp.mysql.database.azure.com',
        user:       'prediction_app@predictionapp',
        password:   'admin_pass123',
        database:   'PredictionApp'
    })

    const dbAuthenticationKeyRows = databaseConnection.query('SELECT COUNT(*) as rowCount FROM Authentication_Keys WHERE Authentication_Key = ?', [authenticationKey])
    if (dbAuthenticationKeyRows[0].rowCount === 0) {
        databaseConnection.dispose()
        return {
            'StatusCode': 401,
            'ResponseBody': ''
        }
    }

    trainingResultsJSONObject = newTrainingResultsJSONObject
    fs.writeFileSync('JSON/training_results.json', JSON.stringify(trainingResultsJSONObject, null, 4))

    const newAuthenticationKey = crypto.randomBytes(32).toString('hex')
    databaseConnection.query('UPDATE Authentication_Keys SET Authentication_Key = ? WHERE Authentication_Key = ?', [newAuthenticationKey, authenticationKey])
    databaseConnection.dispose()

    return {
        'StatusCode': 200,
        'ResponseBody': ''
    }
}