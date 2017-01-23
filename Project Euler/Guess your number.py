
# coding: utf-8

# In[42]:

lowerbound=1
upperbound=10**4
print "Pick a number between %s and %s." %(lowerbound, upperbound)
u_input=0
while u_input != "e":
	u_input=raw_input("Is your number higher than (h), lower than (l), or equal to (e) %d?" %((upperbound+lowerbound)/2)) 
	if u_input!="h" and u_input!="l" and u_input!="e":
		print "Please enter 'h' or 'l'"
	else:
		if u_input=="e":
			print "Success! Your number is %s." %((upperbound+lowerbound)/2)
			break
		if u_input=="h":
			lowerbound=(upperbound+lowerbound)/2
		if u_input=="l":
			upperbound=(upperbound+lowerbound)/2

# In[11]:

#12345


# In[ ]:



