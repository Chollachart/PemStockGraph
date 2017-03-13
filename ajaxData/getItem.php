<?php
require_once '../function.php';
$arr_return = array();

$obj_db =  new db_class();
$query_string = "select tb.* from (SELECT 
   g.[artcode] as Itemcode
   ,i.[Description]
   ,i.packagedescription
    ,CONVERT(DECIMAL(18,2),(SUM(CASE WHEN g.[warehouse] = 'WH02' AND g.unitcode = 'PC' THEN g.[aantal] ELSE 0 END))) as WH02_PC
    ,CONVERT(DECIMAL(18,2),(SUM(CASE WHEN g.[warehouse] = 'WH02' AND g.unitcode = 'SET' THEN g.[aantal] ELSE 0 END))) as WH02_SET
    ,CONVERT(DECIMAL(18,2),(SUM(CASE WHEN g.[warehouse] = 'W103' AND g.unitcode = 'PC' THEN g.[aantal] ELSE 0 END))) as W103_PC
    ,CONVERT(DECIMAL(18,2),(SUM(CASE WHEN g.[warehouse] = 'W103' AND g.unitcode = 'SET' THEN g.[aantal] ELSE 0 END))) as W103_SET    
  FROM [gbkmut] g with(nolock)
  inner join [items] i on g.artcode = i.Itemcode
  where g.warehouse in ('W103','WH02')
  and g.unitcode in ('PC','SET')
  and g.transtype = 'N' 
  AND g.reknr = 117300
  AND i.Assortment = 100
  AND i.Condition = 'A'
  group by g.artcode,i.[Description],i.packagedescription

  ) tb order by tb.Itemcode";
$params = NULL;  
$arr_query = $obj_db->query_data($query_string,$params);

if(is_array($arr_query)){
	$query_status = true;
}else{
	$query_status = false;
}

array_push($arr_return,$query_status);
array_push($arr_return,$arr_query);
echo json_encode($arr_return);
?>