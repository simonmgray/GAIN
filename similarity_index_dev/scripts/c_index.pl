#!/opt/csw/bin/perl
use lib "/opt/csw/lib/perl/csw";

#*********************************************************************************************
#
# Written by Alos Diallo, Walhout Lab
# This program will take in a matrix an generate a geometric matrix as a result.
#
# Requirments 
#	Perl, R,  
#	Perl packages warnings, strict	
# References
# 	
#	http://stat.ethz.ch/R-manual/R-patched/library/base/html/matmult.html
#*********************************************************************************************
use warnings;
use strict;
my $matrix_name = $ARGV[0];

my $location_m = 0;
$location_m = $ARGV[1];
my $output_location = $ARGV[2];
chdir $location_m;
my $new_loc = $location_m.$matrix_name;
my $myPval = `/heap/opt/bin/Rscript /heap/lab_website/similarity_index_dev/scripts/trans.r $new_loc`;
chomp $myPval;



sub toy_matrix(){
	open TOY, "$matrix_name" or die $!;
	
	my ($line,$i,$k,$j,$element);
	my (@main_2D_array,@row_array);
	$line=$i=$k=$j=$element = 0;
	while($line = <TOY>){ 
		# Chop off new line character, skip the comments and empty lines.                 
		chomp($line); 
		@row_array = split(/\t/, $line);
	   $j=0;
		foreach $element (@row_array){
			$main_2D_array[$i][$j++] =$element;
		}
		$i++;
	}
	
	
	#close (TOY);
	return(\@main_2D_array,\@row_array,$i);
}

my ($matrixTwoD,$row_array,$i);
($matrixTwoD,$row_array,$i)=&toy_matrix();
my @main_2D_array = @$matrixTwoD;
my @row_array = @$row_array;

sub result_matrix(){
	open RESULTS, "result.txt" or die $!;
	
	my ($line,$i,$k,$j,$element);
	my (@main_2D_array,@row_array);
	$line=$i=$k=$j=$element = 0;
	while($line = <RESULTS>){ 
		# Chop off new line character, skip the comments and empty lines.                 
		chomp($line); 
		@row_array = split(/\t/, $line);
	   $j=0;
		foreach $element (@row_array){
			$main_2D_array[$i][$j++] =$element;			
		}
		$i++;
	}
	
	
	close (RESULTS);
	return(\@main_2D_array,\@row_array,$i);
}

my ($matrixTwoD_result,$row_array_result,$i_r);
($matrixTwoD_result,$row_array_result,$i_r)=&result_matrix();
my @main_2D_array_result = @$matrixTwoD_result;
my @row_array_result = @$row_array_result;

sub geo($$$$){

	
	system("rm -rf result.txt");
	
	my $main_2D_array_ref = shift;	
	my $main_2D_array_result_ref = shift;
	my $row_array_ref = shift;
	my $i = shift;
	my $output_location = shift;
	my @main_2D_array = @$main_2D_array_ref;
	my @main_2D_array_result= @$main_2D_array_result_ref;
	my @row_array = @$row_array_ref;
	my ($l,$w,$a,$b,$c);
	$l=$w=$a=$b=$c=0;
	my @spot=[];
	my $temp = length(@row_array);
	my $other = 0;
	my @jaccard = [];
	chdir $output_location;
	open(OUT,">"."c_results.txt") or die "Couldn't open: $!";	
	
	for($l=0; $l<$i; $l++){
		for($w=0; $w<$i; $w++){

			$a = $main_2D_array_result[$l][$w];
			$b = $main_2D_array_result[$l][$l];
			$c = $main_2D_array_result[$w][$w];
			$jaccard[$l][$w] = $a**2/($b*$c);
			$jaccard[$l][$w] = sqrt($jaccard[$l][$w]);
			if(($jaccard[$l][$w] != 1) or ($jaccard[$l][$w] != 0)){
				$jaccard[$l][$w] = sprintf("%.3f", $jaccard[$l][$w]); 
			}
			if($w eq ($i-1)){
				print OUT "$jaccard[$l][$w]"; 
			}
			else{
				print OUT "$jaccard[$l][$w]\t";
			}	

		}

		print OUT"\n";
	}	

	
	print "Your done. \n";
	close(OUT);
}


()=&geo(\@main_2D_array,\@main_2D_array_result,\@row_array_result,$i,$output_location);
