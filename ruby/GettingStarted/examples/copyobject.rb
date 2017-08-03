require 'aws-sdk'
require 'pp'

s3 = Aws::S3::Client.new(endpoint: "https://hb.bizmrg.com")

bucket = "newbucket"
object = "file"
body   = "original object"
copy_object = "copy"

puts "put object \"#{object}\" in bucket \"#{bucket}\""
s3.put_object(
    bucket: bucket,
    key: object,
    body: body
)

puts "copy object \"#{object}\" from bucket \"#{bucket}\" into object \"#{copy_object}\""
s3.copy_object(
    bucket: bucket,
    copy_source: "#{bucket}/#{object}",
    key: copy_object
)

resp_orig = s3.get_object(
    bucket: bucket,
    key: object,
)
puts "Etag of original file: " + resp_orig["etag"] + "\n"

resp_copy = s3.get_object(
    bucket: bucket,
    key: copy_object,
)
puts "Etag of copy: " + resp_copy["etag"]
