<?php
    require '../../vendor/autoload.php';
    use Aws\S3\S3Client;
    use PHPUnit\Framework\TestCase; 
    
    class s3test extends TestCase
    {
        const BUCKET = 'newbucket';
        const KEY = 'sdk_file';
        
        public function testPutObject(): void
        {
            $content = "body_content";
            $s3Client = new S3Client([
                'credentials' => [
                    'key'    => 'AccessKeyEXAMPLE',
                    'secret' => 'TheVeryLongLongLongSecretKeyEXAMPLE',
                ],
                'endpoint' => 'https://hb.bizmrg.com',
                'region'   => 'ru-msk',
                'version'  => 'latest',
            ]);
            $res = $s3Client->putObject([
                'Key'    => self::KEY,
                'Bucket' => self::BUCKET,
                'Body'   => $content,
            ]);
            $result = $s3Client->getObject([
                'Bucket' => self::BUCKET,
                'Key'    => self::KEY,
            ]);
            $this->assertEquals(
                $content,
                $result['Body']
            );
        }
        public function testPutCopyObject(): void
        {
            $sourcebucket = self::BUCKET;
            $sourcekey    = self::KEY;
            $key          = "copy_sdk_file";
            $bucket       = $sourcebucket;
            
            $s3Client = new S3Client([
                'credentials' => [
                    'key'    => 'AccessKeyEXAMPLE',
                    'secret' => 'TheVeryLongLongLongSecretKeyEXAMPLE',
                ],
                'endpoint' => 'https://hb.bizmrg.com',
                'region'   => 'ru-msk',
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
            $key          = self::KEY;
            $content      = "content_of_file";
            
            $s3Client = new S3Client([
                'credentials' => [
                    'key'    => 'AccessKeyEXAMPLE',
                    'secret' => 'TheVeryLongLongLongSecretKeyEXAMPLE',
                ],
                'endpoint' => 'https://hb.bizmrg.com',
                'region'   => 'ru-msk',
                'version'  => 'latest',
            ]);
            $s3Client->putObject([
                'Key'    => self::KEY,
                'Bucket' => self::BUCKET,
                'Body'   => $content,
            ]);
            $result = $s3Client->deleteObject([
                'Key'    => self::KEY,
                'Bucket' => self::BUCKET,
            ]);
            $this->assertEquals(
                204,
                $result['@metadata']["statusCode"]
            );
        }
    }
?>
