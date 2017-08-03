require 'aws-sdk'
require 'json'

s3 = Aws::S3::Client.new(
    profile: 'project1', 
    region: 'ru-msk',
    endpoint: 'https://hb.bizmrg.com',
)
bucketname = "newbucket"
puts "create bucket \"bucketname\""
s3.create_bucket(bucket: bucketname)
puts "all your buckets:"
resp = s3.list_buckets
resp.buckets.each do |bucket|
  puts bucket.name
end
