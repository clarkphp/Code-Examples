<?php
# Reference material
// Professional Web APIs with PHP, by Paul Michael Reinheimer, Wrox/Wiley Publishing, 2006
// Pro PHP XML and Web Services, by Robert Richards, Apress, 2006

// Loose coupling with proxy classes:
// Application is not required to know much about the components it communicates with.
// A Web Service and a client may communicate using Soap (most common) messages,
// which encapsulate the 'in' and 'out' messages as XML.
// The proxy class handles mapping parameters to XML elements and then sends them via
// a Soap message over the network.

// XML-RPC data types
//
//Array: An array of values with no keys
//Base64: A base64 encoded piece of data, usually binary data
//Boolean: Boolean value
//Date: ISO rendered date
//Double: Double precision floating point number
//Integer: Whole number
//String: String of characters
//Struct: Associative array
//Nil: null

# Zend Studio Help | Zend Studio for Eclipse User Guide | Welcome to the Online Help | Tasks | Working with WSDL


# Web Services
//Create a new controller that handle Soap requests for listing all the items in the blog.
//Create:
//- a new controller for handling the request
//- a library item that can be exposed using Soap that returns an array of all the items in the Blog
//- a Soap client in a separate file for making the Soap requests, which uses var_dump to display the results.

# application/model/soap.php - create the WSDL from this file
require_once APPLICATION_PATH . '/model/blogs.php';
class SoapArticle
{
    public function getArticles()
    {
        $return = array();
        foreach (ZBlog_Model_Blogs::getEntries() as $entry) {
            $ent = array();
            foreach ($entry as $key => $val) {
                $ent[$key] = utf8_encode($val);
            }
            $return[] = $ent;
        }
        return $return;
    }
}

# application/controllers/soapController.php - Soap server handles incoming requests
require_once APPLICATION_PATH .  '/model/soap.php';
class soapController {
    public function indexAction() {
        $soapServer = new SoapServer('../html/Articles.wsdl');
        $soapServer->setClass('SoapArticle');
        $soapServer->handle();
    }
}

# html/soap.php - soap client makes Soap requests
$soapClient = new SoapClient('http://localhost or IP or domain name/Articles.wsdl');
var_dump($soapClient->getArticles());




# Opcode Caching
# Acceleration vs. Caching (acceleration is running precompiled code, caching is saving the
# OUTPUT of a script for future use.
