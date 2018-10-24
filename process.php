<?php

error_reporting(E_ERROR | E_PARSE);

$file = file_get_contents("test.log");

$result = explode("processing ", trim($file));

//print_r($result);

$counter_hasNative = 0;
$counter_nativeInterfaces = 0;
$counter_hasNative_noActivity = 0;
$counter_nativeInterfaces_noActivity = 0;
$counter_parameters = 0;
$interface_name = array();
$interface_amount = array();
$return_types = array();
$parameter_length = array();
$parameter_types = array();
$access_private = 0;
$access_public = 0;

foreach($result as $analysis_log){
	$tmp = explode("\n",$analysis_log);
	if(sizeof($tmp)>3){
		$counter_hasNative ++;
		$counter_nativeInterfaces = $counter_nativeInterfaces+sizeof($tmp)-3;
		if(strpos($analysis_log,"onCreate")==false){
			$counter_hasNative_noActivity ++;
			$counter_nativeInterfaces_noActivity += sizeof($tmp)-3;
		
			$interfaceAmount = sizeof($tmp)-3;	
			if(array_key_exists($interfaceAmount,$interface_amount)){
				$interface_amount["$interfaceAmount"]+=1;
			}else{
				$interface_amount["$interfaceAmount"] = 1;
			}

			// record the interface name;
			$package = str_replace("package:","",$tmp[1]);

			for($i=3; $i<sizeof($tmp); $i++){
				$interface = $tmp[$i];
				if(strstr($interface, "private")==false){
					$access_public++;
					$interface = str_replace("public","",$interface);
				}else{
					$access_private++;
					$interface = str_replace("private","",$interface);
				}
				$tmp1 = explode("(",$interface);
				$name = trim($tmp1[0]);
				$tmp2 = explode(")",$tmp1[1]);
				$params = trim($tmp2[0]);
				$rt = trim($tmp2[1]);
				//interface names;
				if(array_key_exists($name,$interface_name)){
					$interface_name["$name"]+=1;
				}else{
					$interface_name["$name"] = 1;
				}
				if($params!=""){
				//parameter numbers;
					$params_arr = explode(" ",$params);
					$counter_parameters += sizeof($params_arr);
					if(array_key_exists(sizeof($params_arr),$parameter_size)){
						$parameter_size[sizeof($params_arr)]+=1;
					}else{
						$parameter_size[sizeof($params_arr)] = 1;
					}
					foreach($params_arr as $paramt){	
						if(array_key_exists($paramt,$parameter_type)){
							$parameter_type[$paramt]+=1;
						}else{
							$parameter_type[$paramt] = 1;
						}
					}

				}
				
				if(array_key_exists($rt,$return_types)){
					$return_types["$rt"]+=1;
				}else{
					$return_types["$rt"] = 1;
				}
				
			}
		}
	}

}

echo "projects that have native interface:".$counter_hasNative."\n";
echo "average native interface per project:".floor($counter_nativeInterfaces/$counter_hasNative)."\n";

echo "projects that have native interface (and don't have native activity):".$counter_hasNative_noActivity."\n";
echo "average native interface per project with native interface without native activity:".floor($counter_nativeInterfaces_noActivity/$counter_hasNative_noActivity)."\n";

echo "total interfaces/parameters:".$counter_nativeInterfaces_noActivity."/".$counter_parameters;

echo "\n--------------------------detailed report------------------------------------\n";
ksort($parameter_size);
ksort($interface_amount);
arsort($parameter_type);
arsort($return_types);
arsort($interface_name);

echo "Interfaces: interfaces per app ~ number of apps\n";
print_r($interface_amount); 
echo "-----------------------------------------------------------------------------\n";

echo "Interfaces: key~ interfaceName; value~ how many apps use this interface\n";
print_r($interface_name); 
echo "-----------------------------------------------------------------------------\n";

echo "ParameterSize: parameter size ~ number\n";
print_r($parameter_size);
echo "------------------------------------------------------------------------------\n";

echo "ParameterTypes: parameter type~ number\n";
print_r($parameter_type);
echo "------------------------------------------------------------------------------\n";

echo "Return Types: return type ~ number \n";
print_r($return_types);
echo "------------------------------------------------------------------------------\n";
