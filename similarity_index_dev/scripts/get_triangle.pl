#!/opt/csw/bin/perl
my $element = 0;
my $line = 0;
my @triangle;
my $z = 0;
my $y = 0;

open TRIANGLE, "triangle.txt" or die $!;

while($line = <TRIANGLE>){ 
	# Chop off new line character, skip the comments and empty lines.                 
	chomp($line); 
	my @row_array = split(/\t/, $line);
   $z=0;
	foreach $element (@row_array){
		$triangle[$y][$z++] =$element;
	}
	$y++;
}

open(LIST,">"."trangle_list_".".txt");
for($l=0; $l<$y; $l++){
	for($m=0; $m<$z; $m++){
		my $place_holder = 'TRUE ';
		#print"$triangle[$l][$m]$place_holder";
		if($triangle[$l][$m] eq $place_holder){
			print LIST "$matrix[$l][$m]\n";
			
		}
		#print "\n";
	}
}
close LIST;