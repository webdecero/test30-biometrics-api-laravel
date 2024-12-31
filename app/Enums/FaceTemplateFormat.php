<?php
namespace App\Enums;


enum FaceTemplateFormat: string
{
    case VGG_FACE = 'VGG-Face';
    case FACENET = 'Facenet';
    case FACENET512 = 'Facenet512';
    case OPENFACE = 'OpenFace';
    case DEEPFACE = 'DeepFace';
    case DEEPID = 'DeepID';
    case ARCFACE = 'ArcFace';
    case DLIB = 'Dlib';
    case SFACE = 'SFace';
    case GHOSTFACENET = 'GhostFaceNet';

}
