pipeline {
    agent { label 'epsi' }
    stages {
        stage ('install dnt4 test') {
            steps {
                sh '''
                    echo "LOCAL_USER=1001\nMYSQL_PORT=3307\nNGINX_PORT=81\nADMINER_PORT=8001\nDATABASE_URL=mysql://epsi:epsimysql@mysql:3306/epsi?serverVersion=8.0" > .env.local
                    docker-compose down
                    docker-compose -f docker-compose.dev.yml --env-file .env.local up -d
                    docker-compose exec php composer install
                '''
            }
        }
        stage ('Unit test + Integration test') {
            steps {
                sh '''
                    curl http://localhost:81/api
                '''
            }
        }
    }
    post {
        failure {  
            mail bcc: '', body: "<b>Projet DNT4</b> :<br>La ville de Paris souhaite partager plus largement les données récolter par les anciennes solutions informatiques en exportant ces données sur la plateforme OpenData française. Les données en entrées sont sous format csv et l’export doit être compatible avec l’API d’OpenData. <br>${env.JOB_NAME} <br>Build Number: ${env.BUILD_NUMBER} <br> URL de build: ${env.BUILD_URL}", cc: 'yoann.clement@hotmail.fr', charset: 'UTF-8', from: 'mat.planchot@gmail.com', mimeType: 'text/html', replyTo: '', subject: "ERROR CI: Project name -> ${env.JOB_NAME}", to: "matthieu.planchot@hotmail.fr";  
        } 
    } 
}
