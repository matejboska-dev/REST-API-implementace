<?php

require_once(__DIR__.'./vendor/vCard-parser-master/vCard.php');


	 
	function OutputvCard(vCard $vCard)
	{
		echo '<h2>'.$vCard -> FN[0].'</h2>';

		if ($vCard -> PHOTO)
		{
			foreach ($vCard -> PHOTO as $Photo)
			{
				if ($Photo['Encoding'] == 'b')
				{
					echo '<img src="data:image/'.$Photo['Type'][0].';base64,'.$Photo['Value'].'" /><br />';
				}
				else
				{
					echo '<img src="'.$Photo['Value'].'" /><br />';
				}

				/*
				// It can also be saved to a file
				try
				{
					$vCard -> SaveFile('photo', 0, 'test_image.jpg');
					// The parameters are:
					//	- name of the file we want to save (photo, logo or sound)
					//	- index of the file in case of multiple files (defaults to 0)
					//	- target path to save to, including the filenam
				}
				catch (Exception $E)
				{
					// Target path not writable
				}
				*/
			}
		}

		foreach ($vCard -> N as $Name)
		{
			echo '<h3>Name: '.$Name['FirstName'].' '.$Name['LastName'].'</h3>';
		}

		foreach ($vCard -> ORG as $Organization)
		{
			echo '<h3>Organization: '.$Organization['Name'].
				($Organization['Unit1'] || $Organization['Unit2'] ?
					' ('.implode(', ', array($Organization['Unit1'], $Organization['Unit2'])).')' :
					''
				).'</h3>';
		}

		if ($vCard -> TEL)
		{
			echo '<p><h4>Phone</h4>';
			foreach ($vCard -> TEL as $Tel)
			{
				if (is_scalar($Tel))
				{
					echo $Tel.'<br />';
				}
				else
				{
					echo $Tel['Value'].' ('.implode(', ', $Tel['Type']).')<br />';
				}
			}
			echo '</p>';
		}

		if ($vCard -> EMAIL)
		{
			echo '<p><h4>Email</h4>';
			foreach ($vCard -> EMAIL as $Email)
			{
				if (is_scalar($Email))
				{
					echo $Email;
				}
				else
				{
					echo $Email['Value'].' ('.implode(', ', $Email['Type']).')<br />';
				}
			}
			echo '</p>';
		}

		if ($vCard -> URL)
		{
			echo '<p><h4>URL</h4>';
			foreach ($vCard -> URL as $URL)
			{
				if (is_scalar($URL))
				{
					echo $URL.'<br />';
				}
				else
				{
					echo $URL['Value'].'<br />';
				}
			}
			echo '</p>';
		}

		if ($vCard -> IMPP)
		{
			echo '<p><h4>Instant messaging</h4>';
			foreach ($vCard -> IMPP as $IMPP)
			{
				if (is_scalar($IMPP))
				{
					echo $IMPP.'<br />';
				}
				else
				{
					echo $IMPP['Value'].'<br/ >';
				}
			}
			echo '</p>';
		}

		if ($vCard -> ADR)
		{
			foreach ($vCard -> ADR as $Address)
			{
				echo '<p><h4>Address ('.implode(', ', $Address['Type']).')</h4>';
				echo 'Street address: <strong>'.($Address['StreetAddress'] ? $Address['StreetAddress'] : '-').'</strong><br />'.
					'PO Box: <strong>'.($Address['POBox'] ? $Address['POBox'] : '-').'</strong><br />'.
					'Extended address: <strong>'.($Address['ExtendedAddress'] ? $Address['ExtendedAddress'] : '-').'</strong><br />'.
					'Locality: <strong>'.($Address['Locality'] ? $Address['Locality'] : '-').'</strong><br />'.
					'Region: <strong>'.($Address['Region'] ? $Address['Region'] : '-').'</strong><br />'.
					'ZIP/Post code: <strong>'.($Address['PostalCode'] ? $Address['PostalCode'] : '-').'</strong><br />'.
					'Country: <strong>'.($Address['Country'] ? $Address['Country'] : '-').'</strong>';
			}
			echo '</p>';
		}

		if ($vCard -> AGENT)
		{
			echo '<h4>Agents</h4>';
			foreach ($vCard -> AGENT as $Agent)
			{
				if (is_scalar($Agent))
				{
					echo '<div class="Agent">'.$Agent.'</div>';
				}
				elseif (is_a($Agent, 'vCard'))
				{
					echo '<div class="Agent">';
					OutputvCard($Agent);
					echo '</div>';
				}
			}
		}
	}
    
    
//    $vcard_path="./tmp/Example3.0.vcf";


	$vCard = new vCard(
		__DIR__.$vcard_path, // Path to vCard file
		false, // Raw vCard text, can be used instead of a file
		array( // Option array
			// This lets you get single values for elements that could contain multiple values but have only one value.
			//	This defaults to false so every value that could have multiple values is returned as array.
			'Collapse' => false
		)
	);
    
    $vcard_array= array();
    
	if (count($vCard) == 0)
	{
		throw new Exception('vCard test: empty vCard!');
	}
	// if the file contains a single vCard, it is accessible directly.
	elseif (count($vCard) == 1)
	{
		//OutputvCard($vCard);
        foreach ($vCard -> N as $Name)
		{
			$vcard_array['surname']= $Name['FirstName']." ".$Name['LastName']; 
            
		}

		foreach ($vCard -> ORG as $Organization)
		{
			$vcard_array['name'] = $Organization['Name'];
				
		}
        foreach ($vCard -> EMAIL as $Email)
			{
				if (is_scalar($Email))
				{
					$vcard_array['email'] = $Email;
				}
                else
				{
					if ($Email['Value']) $vcard_array['email']=$Email['Value'];
				}
                
                }
        $vcard_array['notes']="";
        foreach ($vCard -> TEL as $Tel)
			{
				if (is_scalar($Tel))
				{
					$vcard_array['phone'] = $Tel;
				}
                	else
				{
                    if ($Tel['Value']) $vcard_array['phone']=$Tel['Value'];
				
				}
				
			}
		
        foreach ($vCard -> URL as $URL)
			{
				if (is_scalar($URL))
				{
					$vcard_array['note']+=$URL;
				}
                else {
                
                if ($URL['Value']) $vcard_array['note']+=$URL['Value'];
                }
			}
        
        $vcard_array['vcard']=1;    
	}
	// if the file contains multiple vCards, they are accessible as elements of an array
	/*else
	{
		foreach ($vCard as $Index => $vCardPart)
		{
			OutputvCard($vCardPart);
		}
	}
    */
//echo "<pre>";
//print_r($vcard_array);
echo json_encode($vcard_array);
?>