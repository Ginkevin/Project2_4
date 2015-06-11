package Database;

import java.io.BufferedReader;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.IOException;
import java.io.RandomAccessFile;

public class xmlParser {
	RandomAccessFile fileWorker;
	int Primairy_key = 100000;
	
	public xmlParser(){
		try (BufferedReader br = new BufferedReader(new FileReader(getFileLocation("festival")))) {
			fileWorker = new RandomAccessFile(getFileLocation("artist"), "rw");
			fileWorker.seek(0);
			fileWorker.writeBytes("<?xml version='1.0' encoding='us-ascii'?>" + "\r\n");
			fileWorker.writeBytes("<pages>" + "\r\n");
			String line;
		    	while ((line = br.readLine()) != null) {
		    		line = line.replace(">", "");
		    		fileWorker.writeBytes("<link>"+"\r\n");
		    		fileWorker.writeBytes("<title>"+ line + "</title>" +"\r\n");
		    		fileWorker.writeBytes("<url>"+ "http://127.0.0.1/2_4/Template/artist.php?name="+ Primairy_key + "</url>" +"\r\n");
		    		Primairy_key++;
		    		fileWorker.writeBytes("</link>"+"\r\n");
		    		fileWorker.seek(fileWorker.length());
		    	}
		    fileWorker.writeBytes("</pages>");
		} catch (IOException e) {e.printStackTrace();}
	}
	
	public String getFileLocation(String parameter){
		if(parameter.contains("artist")){
			return "Tables/Indexed/Artist.xml"; 
		}
		else if(parameter.contains("festival")){
			return 	"Tables/Indexed/Festival2.txt";
		}
		else return "false";
		 
	}
}
