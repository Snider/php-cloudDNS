<?php
/**
 *
 * Rackspace DNS PHP API sample.php
 * @author Alon Ben David
 * @copyright CoolGeex.com
 */


$sampleImport = "coolgeex0007.com.      3600 	IN	SOA	ns.rackspace.com. sample@coolgeex0007.com. 1308874739 3600 3600 3600 3600
coolgeex0007.com.		86400	IN	A	110.11.12.16
coolgeex0007.com.		3600	IN	MX	5 mail2.coolgeex0007.com.
www.coolgeex0007.com.	5400	IN	CNAME	coolgeex0007.com.";


require_once "rackDNS.php";

$rs_user = 'Your_Rackspace_API_USER'; 
$rs_api_key = 'Your_Rackspace_API_KEY';

$dns = new rackDNS($rs_user,$rs_api_key); //($user, $key, $endpoint = 'US') $endpoint can be UK or US

// Show all domains avalible
$results = $dns->list_domains(50,0); //($limit = 10, $offset = 0)
echo "list_domains:\n"; print_r($results);


foreach($results['domains'] as $res)
{
	echo $res['name'] . "\n";
	$sampleID = $res['id'];
}


$results = $dns->list_subdomains($sampleID);//($domainID)
echo "list_subdomains:\n"; print_r($results);

$results = $dns->domain_export($sampleID);//($domainID)
echo "list_records:\n"; print_r($results);

$results = $dns->list_records($sampleID);//($domainID)
echo "list_records:\n"; print_r($results);

foreach($results['records'] as $res) {$recID = $res['id'];}

$results = $dns->list_record_details($sampleID,$recID);//($domainID,$recordID)
echo "list_record_details:\n"; print_r($results);


$results = $dns->domain_import($sampleImport);
echo "domain_import:\n"; print_r($results);


$results = $dns->list_domain_search('coolgeex0007.com');
echo "list_domain_search:\n"; print_r($results);


foreach($results['domains'] as $res) {$sampleID = $res['id'];}

$results = $dns->modify_domain($sampleID,'info@coolgeex0007.com'); //($domainID = false , $email = false , $ttl = 86400 , $comment = 'Modify Domain Using rackDNS API')
echo "modify_domain:\n"; print_r($results);


$results = $dns->delete_domains($sampleID);
echo "delete_domains:\n"; print_r($results);

//delete_domain_record($domainID,$recordID)
//list_domain_details($domainID = false, $showRecords = false, $showSubdomains = false);
//create_domain($name = false, $email = false, $records = array())
//create_domain_record($domainID = false, $records = array())
//create_domain_record_helper($type = false, $name = false, $data = false, $ttl = 86400, $priority = false)

echo "\n" . $dns->getLastResponseStatus(); //returns status code
echo "\n" . $dns->getLastResponseMessage();//returns status message

?>