# listenerbot
This is a Telegram bot webhook, created by Felix Lepoutre. This webhook only reads what a specific user in a group says, and then reposts that into a telegram channel.
The listenerbot-multi is setup with an array of allowed people, optionally filtered by specific keywords.  

Usage is free. If you need help with installation please contact me. Also, i'd be very happy to just hear from you when you use the bot! Telegram: @felixlepoutre
ETH tipjar: 0x40F56AF593C74C35aAa8df245191bE8Fdb0c9FdB

Instructions
1. Create a bots with @botfather in Telegram. This will both listen and post. The bot should be allowed groups and disable group privacy so he listens to all messages. 
2. Add the bot to the group the user you want to filter out is in. NOTE: If the group is a supergroup, the bot must be an admin in the group. 
3. Create an announcement channel, and get into the settings to add an admin. Find your bot to add as an admin with posting rights. No need to add the bot into the channel first, right now telegram doesn't even allow this. 
4. define vars below 
5. upload this script. For true noobs, i suggest registering a free heroku account, putting the script in the Web folder of the heroku php-getting-started folder of this tutorial and then git the script to your heroku environemt: https://devcenter.heroku.com/articles/getting-started-with-php#introduction
6. set/update the listener webhook url, so all messages will be sent to this script. You can do this with the 'setwebhook.html' script. Just insert your bot token the @botfather gave to you, your url (without https:// !!) and you can keep the port at 88. If you chose the heroku service and have pushed your code, then your url will be: <appname>.heroku.com/listenerbot.php

