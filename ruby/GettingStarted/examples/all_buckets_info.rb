require 'aws-sdk'

region = 'us-west-2'
s3 = Aws::S3::Resource.new(
    region: 'ru-msk',
    access_key_id: 'AccessKeyEXAMPLE',
    secret_access_key: 'TheVeryLongLongLongSecretKeyEXAMPLE',
    endpoint: 'http://hb.bizmrg.com'
)
puts "all buckets:\n"
s3.buckets.limit(50).each do |b|
  puts "#{b.name}"
end
