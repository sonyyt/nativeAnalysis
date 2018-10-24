#!/usr/bin/env python
from __future__ import print_function
from androguard.core.androconf import *
from androguard.misc import *
from androguard.session import Session
import datetime
import os
import getopt
import logging
import glob
# Import commonly used classes
from androguard.core.bytecodes.apk import APK
from androguard.core.bytecodes.dvm import DalvikVMFormat
from androguard.core.analysis.analysis import Analysis


def analysisAPK(apkFileName):
	#todo:check if the apk exist:
	a, d, dx = AnalyzeAPK(apkFileName)
	print("processing "+apkFileName+" "+str(datetime.datetime.now().time()))
	print("package:"+a.get_package())
	
	x = dx.find_methods(".*",".*",".*","public native")
	for m in x:
   		print("public "+m.get_method().get_name()+" "+m.get_method().get_descriptor())
	y = dx.find_methods(".*",".*",".*","private native")
	for m in y:
   		print("private "+m.get_method().get_name()+" "+m.get_method().get_descriptor())


if __name__=="__main__":
	#todo: check if the input exists (sys.argv[1]). otherwise, output input guides. 
	folder = sys.argv[1]
	apks = glob.glob(folder+"/*.apk")
	for i in range(len(apks)):
		#print(apks[i])
		analysisAPK(apks[i])
