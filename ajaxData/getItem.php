<?php
require_once '../function.php';
$arr_return = array();

$obj_db =  new db_class();
$query_string = "select tb.* from (SELECT 
   g.[artcode] as Itemcode
   ,i.[Description]
    ,i.[Class_02]
    ,i.[Assortment]
   ,i.packagedescription
  -- ,g.warehouse
    ,CONVERT(DECIMAL(18,2),(SUM(CASE WHEN g.[warehouse] = 'WH02' THEN g.[aantal] ELSE 0 END))) as WH02_PC
    ,CONVERT(DECIMAL(18,2),(SUM(CASE WHEN g.[warehouse] = 'W103' THEN g.[aantal] ELSE 0 END))) as W103_PC
    
    ,(SELECT TOP 1 [quantity] FROM [001].[dbo].[recipe] b 
    WHERE b.[itemreq] = g.[artcode] 
    AND  b.version = [dbo].[GerVersion](b.[itemprod]) 
     ) as USE_PER_SET
    
  FROM [gbkmut] g with(nolock)
  inner join [items] i on g.artcode = i.Itemcode
  where 
  g.warehouse in ('W103','WH02')
  --and g.unitcode in ('PC','SET')
  and g.transtype = 'N' 
  AND RTRIM(LTRIM(g.reknr)) in ('117300','117600')
  --AND i.Assortment = 100
  AND i.Condition = 'A'
  AND class_02 IN ('D-102','D-103')
  group by g.artcode,i.[Description],i.packagedescription,i.[Class_02],i.Assortment
 
  ) tb 
  where tb.USE_PER_SET IS NOT NULL and tb.USE_PER_SET!=0
  order by tb.Itemcode";
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