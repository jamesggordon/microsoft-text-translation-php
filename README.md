# microsoft-text-translation-php
An example of using the new (as of Feb 2017) Microsoft Azure Text Translation API in PHP.

In order to use the Microsoft Azure Text Translation API you will first need to create a Microsoft Azure account. Once
you've done that you will also need to create a Cognitive Services account from *within* Azure. Currently there is a
free tier that allows you to translate up to 2 million characters per month.

Once you have created your Cognitive Services account and added the Text Translation resource you will need to locate
that resource in your Azure dashboard and copy one of the keys from the "Keys" section and paste it into the `Translator`
class. It doesn't matter which one you use - both should work. Once you have this demo working, feel free to copy and
paste the `Translator` class into your own code, but please remove the hard-coded key and put it somewhere (eg. a
.env file) that is NOT checked into version control. 