from sgmllib import SGMLParser
class ex(SGMLParser):
	def reset(self):
		self.temp=[]
		self.finallist=[]
		self.count=0
		self.flag=0
		SGMLParser.reset(self)
	def unknown_starttag(self,tag,attrs):
		if tag=='td' and len(attrs)>0 and 'class' in attrs[0] and attrs[0][1] in ['t0','t1','t2']:
			self.flag=1
			self.count=self.count+1
	def handle_data(self,text):
		if self.flag==1:
			self.flag=0
			self.temp.append(text)
			if self.count==11:
				self.count=0
				self.finallist.append(self.temp)
				self.temp=[]
	def output(self):
		return self.finallist
import urllib

file=urllib.urlopen('http://www.nseindia.com/content/equities/niftywatch.htm')
dat=file.read()
file.close()
a=ex()
a.feed(dat)
a.close()
list=a.output()
sharedir={}
for elem in list:
	if elem[0]=='M':
		elem[0]='M&M'
	sharedir[elem[0]]=elem[1:]
import MySQLdb
conn=MySQLdb.connect(host='192.168.36.253',user='equitypulse',passwd='earth',db='equitypulse')
cursor=conn.cursor()
qr='select company,last_price from data';
cursor.execute(qr)
answer=cursor.fetchall()
for ans in answer:
	#print 'reached'
	if ans[1]==float(sharedir[ans[0]][3]):
		qr="""update data set flag=0,prev_close='%s',open='%s',high='%s',low='%s',last_price='%s',per_change_prev='%s',total_trad_quantity='%s',turnover='%s' where company='%s'"""%(float(sharedir[ans[0]][4]),float(sharedir[ans[0]][0]),float(sharedir[ans[0]][1]),float(sharedir[ans[0]][2]),float(sharedir[ans[0]][3]),float(sharedir[ans[0]][5]),float(sharedir[ans[0]][6]),float(sharedir[ans[0]][7]),ans[0])
		cursor.execute(qr)
	else:
		qr="""update data set flag=1,prev_close='%s',open='%s',high='%s',low='%s',last_price='%s',per_change_prev='%s',total_trad_quantity='%s',turnover='%s' where company='%s'"""%(float(sharedir[ans[0]][4]),float(sharedir[ans[0]][0]),float(sharedir[ans[0]][1]),float(sharedir[ans[0]][2]),float(sharedir[ans[0]][3]),float(sharedir[ans[0]][5]),float(sharedir[ans[0]][6]),float(sharedir[ans[0]][7]),ans[0])
		cursor.execute(qr)
#print qr
from time import time
now=time()
now=int(now)
for elem in list:
	if elem[0]=='M':
		elem[0]='M&M'
	qr="""insert into NewPrices values('%s','%d','%f')"""%(elem[0],now,float(elem[4]))
	print qr
	cursor.execute(qr)
cursor.close()
conn.commit()
conn.close()
