<?php
    require '../../../vendor/autoload.php';
    use Aws\S3\S3Client;
    use PHPUnit\Framework\TestCase; 
    
    class s3test extends TestCase
    {
        public function testPutObject(): void 
        {
            $bucket  = "jiraf";
            $key     = "sdk_file";
            $content = "body_content";
            $s3Client = new S3Client([
                'credentials' => [
                    'key'    => '6B7hCqne2PnWonbS9wZQie',
                    'secret' => '5QDoD91JUhqRN88oA1UfDGJJk4F4KGBi6hQfiTqgez8B',
                ],
                'endpoint' => 'http://hb.devmail.ru',
                'region'   => 'us-west-2',
                'version'  => 'latest',
            ]);
            $res = $s3Client->putObject([
                'Key'    => $key,
                'Bucket' => $bucket,
                'Body'   => $content,
            ]);
            $result = $s3Client->getObject([
                'Bucket' => $bucket,
                'Key'    => $key,
            ]);
            $this->assertEquals(
                $content,
                $result['Body']
            );
        }
        public function testPutCopyObject(): void
        {  
            $sourcebucket = "jiraf"; 
            $sourcekey    = "sdk_file"; 
            $bucket       = $sourcebucket;
            $key          = "copy_sdk_file";
            
            $s3Client = new S3Client([
                'credentials' => [
                    'key'    => '6B7hCqne2PnWonbS9wZQie',
                    'secret' => '5QDoD91JUhqRN88oA1UfDGJJk4F4KGBi6hQfiTqgez8B',
                ],
                'endpoint' => 'http://hb.devmail.ru',
                'region'   => 'us-west-2',
                'version'  => 'latest',
            ]);
            $s3Client->copyObject([
                'Key'    => $key,
                'Bucket' => $bucket,
                'CopySource' => "{$sourcebucket}/{$sourcekey}",
            ]);
            $copy_result = $s3Client->getObject([
                'Bucket' => $bucket,
                'Key'    => $key,
            ]);
            $result = $s3Client->getObject([
                'Bucket' => $sourcebucket,
                'Key'    => $sourcekey,
            ]);
            $this->assertEquals(
                $copy_result['ETag'],
                $result['ETag']
            );            
        }
        public function testDeleteObject(): void
        {
            $bucket       = "jiraf";
            $key          = "sdk_file";
            $content      = "content_of_file";
            
            $s3Client = new S3Client([
                'credentials' => [
                    'key'    => '6B7hCqne2PnWonbS9wZQie',
                    'secret' => '5QDoD91JUhqRN88oA1UfDGJJk4F4KGBi6hQfiTqgez8B',
                ],
                'endpoint' => 'http://hb.devmail.ru',
                'region'   => 'us-west-2',
                'version'  => 'latest',
            ]);  
            $s3Client->putObject([
                'Key'    => $key,
                'Bucket' => $bucket,
                'Body'   => $content,
            ]);
            $result = $s3Client->deleteObject([
                'Key'    => $key,
                'Bucket' => $bucket,
            ]);
            $this->assertEquals(
                204,
                $result['@metadata']["statusCode"]
            );           
        }
    }
?>
