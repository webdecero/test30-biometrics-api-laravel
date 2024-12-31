<?php
namespace App\Enums;





enum CompanySteps: string
{
    //Creacion de Websapce y dominio principal
    case manager = 'managerStored';
    case managerSSL = 'managerSSL';

    case api = 'apiStored';
    case apiSSL = 'apiSSL';

    case notify = 'notifyStored';
    case notifySSL = 'notifySSL';



    case websocket = 'websocketStored';
    case websocketSSL = 'websocketSSL';




    //Creacion de DB Mysql y User MYSQL
    case mysql = 'mysqlDB';
    //Creacion de DB MongoDB y User
    case mongo = 'mongoDB';

    case gitTemplate = 'gitTemplated';
    case gitTag = 'gitTag';
    // case gitApi = 'gitClonedApi';
    case gitManager = 'gitClonedManager';
    case gitNotify = 'gitClonedNotify';
    case gitWebsocket = 'gitClonedWebsocket';


    case fileODBC = 'fileODBC';
    case fileEnv = 'fileEnv';
    case fileManager = 'fileManager';
    case fileNotify = 'fileNotify';

    case fileWebsocket = 'fileWebsocket';


    case laravelInstall = 'laravelInstall';
    case laravelManager = 'laravelManager';
    case laravelToken = 'laravelToken';


    case migrationMysql = 'migrationMysql';
    case serviceNotify = 'serviceNotify';

    case serviceWebsocket = 'serviceWebsocket';
    case serviceLaravelWorker = 'serviceLaravelWorker';


    case completed = 'completed';
}
