def collatz(n):
	if n % 2 == 0:
		return n / 2
	else:
		return 3*n+1


res = {"1" : 0}
max_num = 0
max_seq = 0
for i in range(2,1000001):
	buffer = []
	seq_length = 0
	num = i
	while True:
		if str(num) in res:
			seq_length += res[str(num)]
			break
		else:
			buffer.append(num)
			num = collatz(num)
			seq_length += 1
	
	for j in range(len(buffer)):
		res[str(buffer[j])] = seq_length - j

	if seq_length > max_seq:
		max_seq = seq_length
		max_num = i

print max_num, max_seq

"""
print res["56991483520"]
big_key = 0
for k in res.keys():
	if int(k) > big_key:
		big_key = int(k)
print big_key
""" 
