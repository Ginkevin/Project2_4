package Server;

import java.io.File;
import Database.Reader;
import Database.Writer;

public class Parser {
	//initialise
	String result = "default";
	Reader reader;
	
	public Parser(String message){
		String[] message_parts = message.split(",");
		if (message_parts[0].equals("GET")){
			if (message_parts[1].equals("ARTIST")){
				reader = new Reader(Integer.parseInt(message_parts[2]));
			}
			else if(message_parts[1].equals("COMMENT")){
				reader = new Reader(Integer.parseInt("-" + message_parts[2]));
			}
		}
		else if(message_parts[0].equals("SET")){
			if(message_parts[1].equals("COMMENT")){
				//[0]set,[1]comment,[2]message,[3]receiver,[4]sender
				Writer(message_parts);
				reader = new Reader(0);
			}
		}
	}	
	
	
	public String getResult(){
		return reader.getResult();
	}
	
	public String[] getResultArray(){
		return reader.getResultArray();
	}
	
	private void Writer(String[] message_parts){
		Writer writer = new Writer(message_parts);
	}
	
}
