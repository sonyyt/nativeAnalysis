# nativeAnalysis

report analysis results on downloaded APK files. 

execution steps: 

1. virtual environment install androguard; 
2. add the getNativeMethods.py to the executable environment of androguard (bin/)
3. python getNativeMethod.py filePathToAPks>test.log
4. php process.php > analysis.log



The generated reports contains: 

projects that have native interface:130
average native interface per project:58
projects that have native interface (and don't have native activity):129
average native interface per project with native interface without native activity:39
total interfaces/parameters:5069/9080

Number of interface per app; 

Name of interfaces and their frequency; 

Number of parameter per interface; 

Parameter type & frequency; 

Return type & frequence;


#author Zheng Song songz@vt.edu 
