package Database;

import java.io.File;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.io.PrintWriter;
import java.io.RandomAccessFile;
import java.io.UnsupportedEncodingException;
import java.util.Calendar;

public class Writer {
	StringBuffer stringbuffer;
	/**
	 * Class used in writing comments to file
	 * folder values as followed:
	 * Indexed_user_year_month
	 * 
	 * file values as followed:
	 * personTo#personFrom#message#curDate
	 * @param message [0]set,[1]comment,[2]message,[3]receiver,[4]sender
	 */
	public Writer(String[] message){
		try {
			folderExists(message[3]);
			write(message);
		}catch (IOException e) {e.printStackTrace();}
	}
	
	private void folderExists(String user) throws FileNotFoundException, UnsupportedEncodingException{
		File f = new File("Tables/Comments/" + user);
		File ff = new File("Tables/Comments/" + user+"/comment.txt");
		if (!f.isDirectory()) {
			f.mkdir();
			if (!ff.exists()){
				PrintWriter writer = new PrintWriter("Tables/Comments/" + user+"/comment.txt", "UTF-8");
			}
		}
		if (f.exists()) {   
			if(!ff.exists()){
				PrintWriter writer = new PrintWriter("Tables/Comments/" + user+"/comment.txt", "UTF-8");
			}
		} 
	}
	
	private void write(String[] message) throws IOException{
		stringbuffer = new StringBuffer();
		stringbuffer.append(message[4] );
		while(stringbuffer.length() < 7){
			stringbuffer.append('>');
		}
		stringbuffer.append("#");
		int[] currDate = getDate();
		if (currDate[1] < 10){
			stringbuffer.append(currDate[0]+"-"+"0"+currDate[1]+"-");
		}
		else{
			stringbuffer.append(currDate[0]+"-"+currDate[1]+"-");
		}
		if (currDate[2] < 10){
			stringbuffer.append("0" + currDate[2]+"#");
		}
		else{
			stringbuffer.append(currDate[2]+"#");
		}
		stringbuffer.append(message[2]);
		while(stringbuffer.length() < 1024){
			stringbuffer.append(">");
		}
		System.out.println(stringbuffer);
		RandomAccessFile fileWorker = new RandomAccessFile(getFileLocation(message[3]), "rw");
		fileWorker.seek(fileWorker.length());
		fileWorker.writeBytes(stringbuffer+"\r\n");
	}
	
	private int[] getDate(){
		Calendar c = Calendar.getInstance();
		int year = c.get(Calendar.YEAR);
		int month = c.get(Calendar.MONTH);
		int day = c.get(Calendar.DAY_OF_MONTH);
		int[] sysDate = new int[3];
		sysDate[0] = year;
		sysDate[1] = month;
		sysDate[2] = day;
		return sysDate;
	}
	
	private String getFileLocation(String user){
		System.out.println("user: "+user);
		return "Tables/Comments/"+user+"/comment.txt";
	}
}
