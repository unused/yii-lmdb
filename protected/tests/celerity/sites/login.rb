require "rubygems"
require "celerity"

browser = Celerity::Browser.new
browser.goto('http://lmdb.local')

puts "oh - it works!" if browser.text.include? 'login'
