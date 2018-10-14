pipeline {
  agent {
    docker {
      image 'easylinux/jenkins-slave:php'
    }

  }
  stages {
    stage('Sources') {
      steps {
        git 'https://github.com/Easylinux/Edicod.git'
      }
    }
  }
}