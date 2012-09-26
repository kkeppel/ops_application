<?

require 'lib/core.php';
header('Content-Type: application/force-download');

if(!$curUser) {
	redirect('/login/?url='.urlencode($_SERVER['REQUEST_URI']));
}

if(getUserGroup($curUser)!='staff') notif('Sorry, you are not supposed to be here.');


echo '"order_id","company_name","city","zip code","head_count","vendor_name","order_for","date_confirmation","datetime_text","food_rating","portioning", "service_rating", "when_next", "c2me_rating", "feedback_public", "feedback_private"
'."\n";

$res = mysql_query(' 
SELECT order_id_t, id_order, order_for, companies.name as company, vendors.name as vendor, datetime_t,  companies.city as city, companies.zip as zip,order_requests.client_id, order_requests.employees as emp, food_rating, portioning, service_rating, when_next, c2me_rating, feedback_private, feedback_public, date
FROM order_requests, clients, companies, vendors, order_proposals, text_vendor, users, order_feedback, tmp_vendor_confirmations
WHERE order_requests.client_id = clients.id_client
AND clients.company_id = companies.id_company
AND order_proposals.vendor_id = vendors.id_vendor
AND order_requests.id_order = order_id_t
AND order_proposals.order_id = order_id_t
AND tmp_vendor_confirmations.order_id = order_id_t
and users.id_user = order_feedback.user_id
and users.client_id =  order_requests.client_id
and order_feedback.order_id = order_id_t

and text=1
ORDER BY datetime_t
');
while($log = mysql_fetch_assoc($res))
{
	echo '"'.$log['id_order'].'","'.utf8_decode($log['company']).'","'.utf8_decode($log['city']).'","'.$log['zip'].'","'.$log['emp'].'","'.utf8_decode($log['vendor']).'","'.$log['order_for'].'","'.$log['date'].'","'.$log['datetime_t'].'","'.$log['food_rating'].'","'.$log['portioning'].'","'.$log['service_rating'].'","'.$log['when_next'].'","'.$log['c2me_rating'].'","'.utf8_decode(str_replace("\r",' ',str_replace('"',"'",str_replace("\n",' ',$log['feedback_public'])))).'","'.utf8_decode(str_replace("\r",' ',str_replace('"',"'",str_replace("\n",' ',$log['feedback_private'])))).'"'."\n";
}



 