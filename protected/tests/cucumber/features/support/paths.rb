module NavigationHelpers
  def path_to(page_name)
    "http://lmdb.local/index-test.php" +
    case page_name

    when /home page/
      '/'

    when /login page/
      '/login.html'
    when /movies page/
      '/movies.html'
    when /wishlist page/
      '/wishlist.html'
    when /users page/
      '/users.html'

    else
      raise "Can't find mapping from \"#{page_name}\" to a path.\n" +
        "Now, go and add a mapping in #{__FILE__}"
    end
  end
end

World(NavigationHelpers)
