<?php

namespace SupportKd\CyxS3Bundle\Model;

use Aws\Exception\CredentialsException;
use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;

/**
 * Created by PhpStorm.
 * User: cyx-Rizwan
 * Date: 28/7/2017
 * Time: 5:30 PM
 */
class CyxAwsModel
{
    /** @var string
     * @Column(type="string")
     */
    private $key;

    /** @var string
     * @Column(type="string")
     */
    private $secret;

    /** @var string
     * @Column(type="string")
     */
    private $region;

    /** @var string
     * @Column(type="string")
     */
    private $version;

    /** @var string
     * @Column(type="string")
     */
    private $bucket;

    /** @var string
     * @Column(type="string")
     */
    private $path;

    /** @var string
     * @Column(type="string")
     */
    private $acl = 'public-read';
	
    public function __construct($container)
    {
        $this->key = $container->getParameter('support_kd_cyx_s3.key');
        $this->secret = $container->getParameter('support_kd_cyx_s3.secret');
        $this->region = $container->getParameter('support_kd_cyx_s3.region');
        $this->version = $container->getParameter('support_kd_cyx_s3.version');

    }

    //Connect To S3
    private function connectS3(){
        try {
            $s3 = new S3Client([
                'version' => $this->version,
                'region' => $this->region,
                'credentials' => [
                    'key' => $this->key,
                    'secret' => $this->secret
                ]
            ]);
        }catch (CredentialsException $e){
            echo $e->getMessage();
        }
        return $s3;
    }

    public function setBucket($bucket)
    {
        $this->bucket = $bucket;
    }

    public function setPath($path)
    {
        $this->path = $path;
    }

    public function setAcl($acl)
    {
        $this->acl = $acl;
    }

    //Put Files
    public function putObject($fileName)
    {
        try {
            $s3 = $this->connectS3();



            $result = $s3->putObject([
                'Bucket' => $this->bucket,
                'Key'    => $fileName,
                'Body'   => fopen($this->path.'/'.$fileName, 'r'),
                'ACL'    => $this->acl,
            ]);

        }catch (S3Exception $e){
            echo $e->getMessage();
        }

        return $result;

    }

    //get Files
    public function getObject($fileName, $bucket)
    {
        try {
            $s3 = $this->connectS3();
            $response = $s3->getObject(array(
                'Bucket' => $bucket,
                'Key'    => $fileName
            ));
        }catch (S3Exception $e){
            echo $e->getMessage();
        }

        return $response;
    }

    //Create Pre Signed Request
    public function getPresignedUrl($fileName, $bucket, $time){
        $presignedUrl = '';
        try {
            $s3 = $this->connectS3();
            $cmd = $s3->getCommand('GetObject', [
                'Bucket' => $bucket,
                'Key'    => $fileName
            ]);

            $request = $s3->createPresignedRequest($cmd, $time); //Time like '+20 minutes'

            $presignedUrl = (string) $request->getUri();

        }catch (S3Exception $e){
            echo $e->getMessage();
        }

        return $presignedUrl;
    }

   
}
