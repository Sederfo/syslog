import re
import csv
import json
import sys
import os
import traceback

try:
    msg = sys.argv[1]
except Exception as e:
    print("exception?")

try:
    #pattern to extract the RECEIVED AT and REPORTED TIME from the string and store them into dates list
    pattern_dates = re.compile('[a-zA-Z]+ +[0-9] +[0-9]{2}:[0-9]{2}:[0-9]{2}')
    dates = re.findall(pattern_dates, msg)
    #WHAT IF DATES ARE WRONGLY FORMATTED/MISSING? then, from host would not be matched..

    # pattern to match text between the two dates
    pattern_from_host = re.compile(f'(?<={dates[0]})(.*)(?={dates[1]})')
    # strip to remove whitespaces, [:-1] to remove last character which is `:`
    from_host = re.search(pattern_from_host, msg).group().strip()[:-1]

    #pattern to match syslog msg
    pattern_syslog = re.compile('%(.*)')
    syslog_msg = re.search(pattern_syslog, msg).group()[1:]

    #pattern to match facility and mnemonic
    pattern_facility = re.compile('[A-Z_]+')
    facility = re.findall(pattern_facility,syslog_msg )[0]
    mnemonic = re.findall(pattern_facility,syslog_msg )[1]

    #pattern to match severity
    pattern_severity = re.compile('-[0-7]-')
    severity = re.search(pattern_severity, syslog_msg).group()[1:2]

    #pattern to match message text
    pattern_message_text = re.compile(':(.*)')
    message_text = re.search(pattern_message_text, syslog_msg).group()[1:].strip()

    with open('syslog_msg.csv', mode='a') as csv_file:
        csv_writer = csv.writer(csv_file, delimiter=',', quotechar='"', quoting=csv.QUOTE_MINIMAL)
        csv_writer.writerow([dates[0], dates[1], facility, severity, from_host, message_text])


    with open('syslog_msg.json', mode='w') as json_file:
        msg_dict = {
            "received at": dates[0],
            "reported time": dates[1],
            "facility": facility,
            "severity": severity,
            "from host": from_host,
            "message": message_text
        }

        json.dump(msg_dict, json_file)


except Exception as e:
    print("Message incorrectly formatted!")
    traceback.print_exc()
else:
    print("Message successfully processed!")
