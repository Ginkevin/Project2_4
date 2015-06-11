package Database;

import java.io.IOException;
import java.io.RandomAccessFile;

public class Reader {
	RandomAccessFile fileWorker;
	String result;
	
	public Reader(int PK){
			try {
				fileWorker = new RandomAccessFile(getFileLocation(), "r");
				Long location = (Long.valueOf(PK) - 100000);
				fileWorker.seek(location * 1000);
				String line = "";
				while ((line = fileWorker.readLine()) != null){
					if (line.contains(""+PK)){
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
	
	public String getFileLocation(){
		return "Tables/Indexed/Table.txt";
	}
	
	public String getResult(){
		return this.result;
	}
	
}
