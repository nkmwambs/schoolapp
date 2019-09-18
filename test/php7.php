<?php

function adder(...$numbers)
{
    $sum = 0;

    foreach ($numbers as $number)
    {
        $sum += $number;
    }

    return $sum;
}

// Both of these work.
//adder(1,2);
echo adder(1,2,3,4,5,6,7);

?>

<script>
	const smartPhones = [
		{'name':'Samsung','price':19800},
		{'name':'Infinix','price':11200},
		{'name':'Nokia','price':8510}
	];
	
	// var prices = smartPhones.map(function(smartPhone){
		// console.log(smartPhone.price);
	// });
	
	var prices = smartPhones.map(smartPhone => console.log(smartPhone.price));
	
</script>

