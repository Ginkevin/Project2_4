package Database;

import java.io.FileNotFoundException;
import java.io.IOException;
import java.io.RandomAccessFile;

public class Reader {
	RandomAccessFile fileWorker;
	String result = "default";
	String[] resultArray = new String[10];
	
	public Reader(int PK){
		System.out.println(PK);	
		if(PK == 0){
				this.result = "comment written succesfully";
			}
			else if(PK < 0){
				try {
					String[] responds = new String[10];
					String Key = ""+PK;
					Key = Key.replace("-", "");
					fileWorker = new RandomAccessFile(getCommentLocation(Key), "r");
					fileWorker.seek(fileWorker.length());
					for (int i = 1; i < 11; i++){
						if ((fileWorker.length() -(1026 * i) < 0)){
							responds[(i-1)] = null;
						}
						else{
						fileWorker.seek((fileWorker.length()-(1026 * i)));
						responds[(i-1)] = fileWorker.readLine();
						}
					}
					this.resultArray = responds;
					//System.out.println("hopelijk succes");
					//for (int j=0; j < responds.length; j++){
					//	System.out.println(responds[j]);
					//}
					
				} catch (IOException e) {	e.printStackTrace();}
				
			}
			else{
			try {
				fileWorker = new RandomAccessFile(getFileLocation(), "r");
				Long location = (Long.valueOf(PK) - 100000);
				Long start_query = System.currentTimeMillis();
				fileWorker.seek(location * 1000);
				String line = "";
				while ((line = fileWorker.readLine()) != null){
					if (line.contains(""+PK)){
						Long end_query = System.currentTimeMillis();
						System.out.println("record found. running time: " + (end_query - start_query) + "miliseconds");
						if (line.contains("&amp;#8217;")){
							line = line.replace("&amp;#8217;", "'");
						}
						if (line.contains("&amp;hellip;")){
							line = line.replace("&amp;hellip;", "/");
						}
						if (line.contains("&quot;")){
							line = line.replace("&quot;", "\"");
						}
						if (line.contains("Discover more music, concerts, videos, and")){
							line = line.replace("Discover more music, concerts, videos, and", "");
						}
						if (line.contains("$")){
							line = line.replace("$", "");
						}
						String[] tmp = new String[3];
						tmp = line.split("#");
						this.result = (tmp[1]);
						break;
					}
				}
			} catch (IOException e) {	e.printStackTrace(); }
			}
	}
	
	public String getFileLocation(){
		return "Tables/Indexed/Table.txt";
	}
	
	public String getCommentLocation(String user){
		return "Tables/Comments/"+user+"/comment.txt";
	}
	
	public String getResult(){
		return this.result;
	}
	
	public String[] getResultArray(){
		return this.resultArray;
	}
	
}
