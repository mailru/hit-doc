<?php 
    require '../../../vendor/autoload.php';
    use Aws\S3\S3Client;
    use Aws\Exception\AwsException;
    use Aws\S3\Exception\S3Exception;
    use Aws\Credentials\CredentialProvider;

    $bucket = 'jiraf';
    $key = 'my-key';
    $content = 'this is the body!';
    
    // provide keys from ini file

    $first_provider = CredentialProvider::defaultProvider();
    $FirstS3Client = new S3Client([
        'region'      => 'us-west-2',
        'version'     => 'latest',
        'credentials' => $first_provider,
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

    // env provider

    $SecondS3Client = new S3Client([
        'region'      => 'us-west-2',
        'version'     => 'latest',
        'credentials' => CredentialProvider::env(),
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

    // ini  provider
    $third_provider = CredentialProvider::ini();
    $third_provider = CredentialProvider::memoize($third_provider);
    
    $ThirdS3Client = new S3Client([
        'region'      => 'us-west-2',
        'version'     => 'latest',
        'credentials' => $third_provider,
        'endpoint' => 'http://hb.devmail.ru'
    ]);
    try {
        $result = $ThirdS3Client->putObject([
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
