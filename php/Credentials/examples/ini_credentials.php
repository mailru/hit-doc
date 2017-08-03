<?php
    require '../../../vendor/autoload.php';
    use Aws\S3\S3Client;
    use Aws\Exception\AwsException;
    use Aws\S3\Exception\S3Exception;
    use Aws\Credentials\CredentialProvider;
    
    $bucket = 'jiraf';
    $key = 'my-key';
    $content = 'this is the body!';

    // s3 client
    // load credentials from enviroment varaible

    $provider = CredentialProvider::env();
    $FirstS3Client = new S3Client([
        'version'     => 'latest',
        'region'      => 'us-west-2',
        'credentials' => $provider,
        'endpoint' => 'http://hb.devmail.ru'
    ]);
    try {
        $result = $FirstS3Client->putObject([
            'Bucket' => $bucket,
            'Key'    => $key,
            'Body'   => $content
        ]);
        echo $result["@metadata"]["statusCode"] . "\n";
    } catch (S3Exception $e) {
        echo $e->getMessage();
    } catch (AwsException $e) {
        echo $e->getAwsRequestId() . "\n";
        echo $e->getAwsErrorType() . "\n";
        echo $e->getAwsErrorCode() . "\n";
    }
    
    //load credentials from ~/.aws/credentials  file
     
    $SecondS3Client = new S3Client ([
        'profile' => 'project1',
        'region'  => 'us-west-2',
        'version' => 'latest',
        'endpoint' => 'http://hb.devmail.ru'
    ]);
    try {
        $result = $SecondS3Client->putObject([
            'Bucket' => $bucket,
            'Key'    => $key,
            'Body'   => $content
        ]);
        echo $result["@metadata"]["statusCode"] . "\n";
    } catch (S3Exception $e) {
        echo $e->getMessage();
    } catch (AwsException $e) {
        echo $e->getAwsRequestId() . "\n";
        echo $e->getAwsErrorType() . "\n";
        echo $e->getAwsErrorCode() . "\n";
    }
?>
