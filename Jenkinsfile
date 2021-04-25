pipeline {
    agent { label 'epsi' }
    stages {
        stage ('pull master / push integration') {
            steps {
                sh '''
                    git pull origin master
                    git push origin HEAD:integration
                '''
            }
        }
        stage ('install build dnt4 test') {
            steps {
                sh '''
                    echo "LOCAL_USER=1001\nMYSQL_PORT=3307\nNGINX_PORT=81\nADMINER_PORT=8001\nDATABASE_URL=mysql://epsi:epsimysql@mysql:3306/epsi?serverVersion=8.0" > .env.local
                    docker-compose -f docker-compose.dev.yml --env-file .env.local up -d
                    docker-compose exec -T php composer install
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
        stage ('push to preprod') {
            steps {
                sh '''
                    git push origin preprod
                '''
            }
        }
    }
    post {  
        always {
            sh 'docker-compose down'
        }
        failure {  
            mail bcc: '', 
            body: "<b>Projet DNT4</b><br><br>${env.JOB_NAME} <br>Build Number: ${env.BUILD_NUMBER} <br> URL de build: ${env.BUILD_URL}", 
            cc: 'yoann.clement@epsi.fr', 
            charset: 'UTF-8', 
            from: 'mat.planchot@gmail.com', 
            mimeType: 'text/html', 
            replyTo: '', 
            subject: "ERROR CI: Project name -> ${env.JOB_NAME}", 
            to: "matthieu.planchot@epsi.fr";
        } 
    } 
}
