<?php    
    require '../../../vendor/autoload.php';
    use Aws\S3\S3Client;
    use Aws\Exception\AwsException;
    use Aws\S3\Exception\S3Exception;
    use PHPUnit\Framework\TestCase;
    $bucket = 'jiraf';
    $key = 'my-key';
    $content = 'this is the body!';
    // s3 client
    // aws access_keys from env

    $FirstS3Client = new S3Client([
        'version' => 'latest',
        'region'  => 'us-east-1',
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
?>
