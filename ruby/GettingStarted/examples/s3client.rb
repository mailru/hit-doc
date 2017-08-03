require 'aws-sdk'
require 'pp'

# add access_key and secret_key
Aws.config.update({
  credentials: Aws::Credentials.new('AccessKeyEXAMPLE', 'TheVeryLongLongLongSecretKeyEXAMPLE')
})

# add bucket_name, object_name and content
bucket  = 'example'
key     = 'ruby_file'
content = "content of ruby file"

puts "try to upload  file: \"#{key}\" from bucket: \"#{bucket}\" with content: \"#{content}\"\n"

s3Client = Aws::S3::Client.new(
	endpoint: 'http://hb.bizmrg.com'
)

put_resp = s3Client.put_object(bucket: bucket, key: key, body: content)
puts "Uploaded object with etag: "+ put_resp['etag']

puts "try to download  file: \"#{key}\" from bucket: \"#{bucket}\" \n"
puts "Content of downloaded file:"
get_resp = s3Client.get_object(bucket: bucket, key: key) do |chunk|
     pp chunk
end
puts "Downloaded object with etag: "+ get_resp['etag']
                


