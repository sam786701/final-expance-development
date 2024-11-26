<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process form data and sanitize inputs
    $form_data = [
        'first_name' => htmlspecialchars($_POST['first_name']),
        'last_name' => htmlspecialchars($_POST['last_name']),
        'caller_id' => htmlspecialchars($_POST['caller_id']),
        'email' => filter_var($_POST['email'], FILTER_SANITIZE_EMAIL),
        'dob' => htmlspecialchars($_POST['dob']),
        'state' => htmlspecialchars($_POST['state']),
        'city' => htmlspecialchars($_POST['city']),
        'zip' => htmlspecialchars($_POST['zip']),
        'xxTrustedFormToken' => htmlspecialchars($_POST['xxTrustedFormToken']),
        'TrustedFormPingUrl' => htmlspecialchars($_POST['TrustedFormPingUrl']),
        'jornaya_leadid' => htmlspecialchars($_POST['jornaya_leadid']),
        'ip_address' => htmlspecialchars($_POST['ip_address']),
        'traffic_source_id' => htmlspecialchars($_POST['traffic_source_id']),
        'ip_region' => htmlspecialchars($_POST['ip_region']),
        'ip_city' => htmlspecialchars($_POST['ip_city']),
        'ip_country' => htmlspecialchars($_POST['ip_country']),
    ];

    // Send data to Google Sheets
    $url = 'https://script.google.com/macros/s/AKfycbxF-qYrIAEFGIPfoCfLPYU9p8_9-5CPlarkTogsd3JeWbdpdqKHsuEQYy8Y8oQkyMMD/exec';
    $postData = http_build_query($form_data);
    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => $postData,
        ],
    ];
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    // Error handling for Google Sheets submission
    if ($result === FALSE) {
        error_log('Failed to submit data to Google Sheets');
        die('Error: Could not submit form');
    }

    // Redirect to a thank-you page or provide a response
    header("Location: /");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <title>Secure Last Expense - Get a Quote</title>
    <link rel="icon" href="https://securelastexpense.com/wp-content/uploads/2024/10/Group-3693-150x150.png" sizes="32x32" />
    <link rel="icon" href="https://securelastexpense.com/wp-content/uploads/2024/10/Group-3693-300x300.png" sizes="192x192" />
    <link rel="apple-touch-icon" href="https://securelastexpense.com/wp-content/uploads/2024/10/Group-3693-300x300.png" />

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        body {
            font-family: 'Arial', sans-serif;
            background-color: #FFFF311A;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 50px 0;
        }

        form {
            padding: 0px 50px 70px 50px;
            margin-top: 40px;
            width: 100%;
            max-width: 786px;
            background-color: #fff;
			border-radius: 10px;
            background-position: bottom center;
            background-repeat: no-repeat;
            background-size: 100% auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 0 7px 35px 0 #0000000d;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #000;
			font-family: 'Poppins';
			font-size: 16px;
			font-weight: 500;
        }

        input {
            width: 100%;
            padding: 15px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #69727d6e;
            border-radius: 5px;
            background: transparent;
			color: #000;
			font-family: 'Poppins';
			font-size: 16px;
        }

        button {
            background-color: #FFFF31;
            color: #000;
            padding: 15px 70px;
            border: none;
            border-radius: 7px;
            cursor: pointer;
            width: 100%;
            font-size: 20px;
            font-weight: 600;
            margin-top: 15px;
			transition: .3s;
        }

        button:hover {
            background-color: #000;
			color: #fff;
			transition: .3s;
        }

        .signature {
            text-align: center;
            color: #555;
            font-size: 10px;
        }
        .logo {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .top1 {
            font-family: 'Poppins';
            font-size: 70px;
            font-weight: 300;
            text-align: center;
            color: #fff;
        }
        .top2 {
            font-family: 'Poppins';
            font-size: 40px;
            font-weight: 700;
            text-align: center;
            color: #000;
        }
        .top3 {
            font-family: 'Poppins';
            font-size: 20px;
            font-weight: 400;
            text-align: center;
            color: #fff;
        }
        .form-content {
            width: 100%;
            margin-top: 75px;
			display: flex;
			flex-direction: row;
			flex-wrap: wrap;
			justify-content: space-between;
			gap: 20px;
        }
		.form-content .FNAME, .form-content .LNAME, .form-content .PHONE, .form-content .EMAIL {
			width: 48%;
		}
		.form-content .DOB {
			width: 100%;
		}
		.form-content .STATE, .form-content .CITY, .form-content .ZIP {
			width: 31.5%;
		}
        h1 {
            font-family: 'Poppins';
            font-size: 22px;
            font-weight: 700;
            text-align: center;
            color: #000;
            margin: 0px 0px -44px 0px;
            padding: 10px 40px 8px 40px;
            background-color: #FFFF31;
            border-radius: 0px 0px 30px 30px;
            z-index: 1;
        }
        .tcp p {
            font-family: 'Poppins';
            font-size: 12px;
            font-weight: 400;
            color: #747474;
        }
		
		@media only screen and (max-width: 600px) {
			.container {
				flex-direction: row;
				flex-wrap: wrap;
    			justify-content: center;
				padding: 50px 10px;
			}
			form {
				padding: 0px 25px 30px 25px;
				max-width: 100%;
			}
			h1 {
				font-size: 20px;
			}
			.top2 {
				font-size: 30px;
				line-height: 1.4em;
			}
			.form-content .FNAME, .form-content .LNAME, .form-content .PHONE, .form-content .EMAIL {
				width: 100%;
			}
			.form-content .STATE, .form-content .CITY, .form-content .ZIP {
				width: 100%;
			}
			input {
				padding: 12px;
				margin-bottom: 0px;
			}
			.tcp p {
				margin: 0;
			}
			button {
				margin-top: 0px;
			}
		}
    </style>
	
	<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-MRQQ73S5');</script>
<!-- End Google Tag Manager -->
</head>
<body>
	
	<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MRQQ73S5"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

    <div class="container">
        <div class="logo">
            <picture 
            style="display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            flex-wrap: nowrap;
            margin: 0px 0px 40px 0px;
            padding: 20px 30px 20px 30px;
            background-color: #000;
            border-radius: 30px 30px 30px 30px;
            box-shadow: 0px 25px 40px 0px rgba(0, 0, 0, 0.25);
            width: 13%;" >
                <source type="image/webp" srcset="https://securelastexpense.com/wp-content/uploads/2024/10/Group-3656-1.png">
                <img src="https://securelastexpense.com/wp-content/uploads/2024/10/Group-3656-1.png" alt="White House "style="width: 100%"/>
            </picture>
        </div>
        <span class="top2">Please Enter The Details Below</span>
        

        <form id="leadForm" action='' method='post'>
            <h1>Get Consultation Now!</h1>
            <div class="form-content">
				<input type='hidden' name='action' value='custom_form_submission'>
                <input type='hidden' value='' name='lead_token'>
                <input type='hidden' value='9999' name='traffic_source_id'>
				<input type='hidden' value='' name='source_url'>
				<input type='hidden' id="ip-address" value='' name='ip_address'>
				<input type='hidden' id="ip-region" value='' name='ip_region'>
				<input type='hidden' id="ip-city" value='' name='ip_city'>
				<input type='hidden' id="ip-country" value='' name='ip_country'>
				<input type='hidden' id='timestamp' name='original_lead_submit_date' value=''>

                <div class="FNAME">
					<label for="firstName">First Name: <span style="color: red;">*</span></label>
                	<input type="text" placeholder="First Name" id="firstName" name="first_name" required>
				</div>

                <div class="LNAME">
					<label for="lastName">Last Name: <span style="color: red;">*</span></label>
                	<input type="text" placeholder="Last Name" id="lastName" name="last_name" required>
				</div>
				
				<div class="PHONE">
					<label for="phoneNumber">Phone Number: <span style="color: red;">*</span></label>
                	<input type="tel" placeholder="Phone Number" id="phoneNumber" name="caller_id" required>
				</div>
				
				<div class="EMAIL">
					<label for="email">Email Address: <span style="color: red;">*</span></label>
                	<input type="email" placeholder="Email Address" id="email" name="email" required>
				</div>
                
                <div class="DOB">
					<label for="dob">Date of Birth (MM-DD-YYYY): <span style="color: red;">*</span></label>
                	<input type="text" placeholder="Date of Birth" id="dob" name="dob" placeholder="MM-DD-YYYY" required>
				</div>

                <div class="STATE">
					<label for="state">State: <span style="color: red;">*</span></label>
                	<input type="text" placeholder="State" id="state" name="state" required>
				</div>
                
                <div class="CITY">
					<label for="city">City: <span style="color: red;">*</span></label>
                	<input type="text" placeholder="City" id="city" name="city" required>
				</div>
                
                <div class="ZIP">
					<label for="zip">Zip Code: <span style="color: red;">*</span></label>
                	<input type="text" placeholder="Zip Code" id="zip" name="zip" required>
				</div>
                
                
                <input id="trusted_form_cert_url" name="trusted_form_cert_url" type="hidden" value=""/>
                <input id="leadid_token" name="jornaya_leadid" type="hidden" value=""/>

                <div class="tcp">
					<p>By clicking “Submit”, I expressly consent to receive marketing phone calls and/or text SMS messages from My Disability Assist and Citizens Disability on the landline and/or mobile number that I have provided, regarding my disability claim, Benefits Optimization, Medicare, and/or Pharmacy services. I confirm that the phone number above is accurate and I am the regular user of that phone. I understand that these calls and/or text messages may be generated using an autodialer and may contain pre-recorded and/or artificial voice messages. I also agree to My Disability Assist and Citizens Disability SMS <a href="https://mydisabilityassist.com/terms-and-conditions/" traget="_black">Terms and Conditions</a> and <a href="https://mydisabilityassist.com/privacy-policy/" traget="_black">Privacy Policy</a>. Consent is not required to obtain any good or service. Reply STOP to cancel, HELP for info. Msg & data rates may apply. Message frequency varies.</p>
                </div>
                
                <button type="button" id="submitButton" class="submission-2" onclick="submitForm()">Submit</button>
            </div>
        </form>
    </div>

    <script id="LeadiDscript" type="text/javascript">
        (function() {
        var s = document.createElement('script');
        s.id = 'LeadiDscript_campaign';
        s.type = 'text/javascript';
        s.async = true;
        s.src = '//create.lidstatic.com/campaign/11209397-31bc-376b-ac50-52df4acc79c5.js?snippet_version=2&f=reset';
        var LeadiDscript = document.getElementById('LeadiDscript');
        LeadiDscript.parentNode.insertBefore(s, LeadiDscript);
        })();
        </script>
        <noscript><img src='//create.leadid.com/noscript.gif?lac=CF4996BF-EAEF-6727-187B-F7D19ACD91A7&lck=11209397-31bc-376b-ac50-52df4acc79c5&snippet_version=2' /></noscript>
        <!-- For Jornaya -->
        
        <!-- TrustedForm -->
        <script type="text/javascript">
        (function() {
        var tf = document.createElement('script');
        tf.type = 'text/javascript'; tf.async = true;
        tf.src = ("https:" == document.location.protocol ? 'https' : 'http') + "://api.trustedform.com/trustedform.js?field=trusted_form_cert_url&ping_field=TrustedFormPingUrl&l=" + new Date().getTime() + Math.random();
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(tf, s);
        })();
        </script>
        <noscript>
        <img src="https://api.trustedform.com/ns.gif" />
        </noscript>

    
    <!----------SCRIPT FOR DOB FORMAT-------->
<script>
    $(document).ready(function() {
		$.get("https://ipinfo.io?token=2bd961e828ebfa", function(response) {
			$("#ip-address").val(response.ip);
			$("#ip-region").val(response.region);
			$("#ip-city").val(response.city);
			$("#ip-country").val(response.country);
		});
		
		$("input[name='source_url']").val(window.location.href);
		
		const now = new Date();
		const formattedTimestamp = now.getFullYear() + '-' +
			('0' + (now.getMonth() + 1)).slice(-2) + '-' +
			('0' + now.getDate()).slice(-2) + ' ' +
			('0' + now.getHours()).slice(-2) + ':' +
			('0' + now.getMinutes()).slice(-2) + ':' +
			('0' + now.getSeconds()).slice(-2);
		$("#timestamp").val(formattedTimestamp);
		
        $("#dob").on("input", function() {
            var dobValue = $(this).val();
            var formattedDob = dobValue.replace(/\D/g, '').replace(/(\d{2})(\d{2})?(\d{0,4})?/, '$1-$2-$3').replace(/--/, '-');
            $(this).val(formattedDob);
        });

        $("#submitButton").on("click", function() {
            var dobValue = $("#dob").val();
            var dobParts = dobValue.split("-");
            if (dobParts.length === 3) {
                var yyyy = dobParts[2];
                var mm = dobParts[0];
                var dd = dobParts[1];
                var formattedDob = yyyy + "-" + mm + "-" + dd;
                $("#dob").val(formattedDob);
            }
            // Now you can submit the form
            $("#leadForm").submit();
        });
    });
</script>

<!-------Trim_Space---------------->
<script>
    // function submitForm() {
    //     let valid = true;
    //     let check = $("input");
    //     for(i=0; i<check.length; i++) {
    //         if($(check[i]).val().length == 0){
    //             valid = false;
    //             break;
    //         }
    //     }
        
    //     if(!valid){
    //         alert('Enter all field ');
    //         return;
    //     }
        
    //     var data = $("form").serializeArray();
		
	// 	const fieldsToExclude = ['ip_region', 'ip_city', 'ip_country']; // Add other fields you want to exclude
	// 	data = data.filter(function(field) {
	// 		return !fieldsToExclude.includes(field.name);
	// 	});
		
	// 	var serializedData = $.param(data);
        
    //     $.post('https://evolvetech-innovations.trackdrive.com/api/v1/leads', data, function(rsp){
    //         if(rsp.status = 200){
    //             alert('Saved');
    //             window.location.reload(true);
    //         }
    //         else{
    //             alert(JSON.stringify(rsp))
    //         }
    //     }).fail(function(response) {
    //         alert('Error: ' + response.responseText);
    //     });    
    // }

    // Add event listeners to trim spaces from input fields
    document.getElementById("firstName").addEventListener("input", function() {
        this.value = this.value.trim();
    });

    document.getElementById("lastName").addEventListener("input", function() {
        this.value = this.value.trim();
    });

    document.getElementById("dob").addEventListener("input", function() {
        this.value = this.value.trim();
    });

    document.getElementById("state").addEventListener("input", function() {
        this.value = this.value.trim();
    });

    document.getElementById("city").addEventListener("input", function() {
        this.value = this.value.trim();
    });

    document.getElementById("zip").addEventListener("input", function() {
        this.value = this.value.trim();
    });
</script>

</body>
</html>