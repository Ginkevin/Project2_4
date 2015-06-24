package Server;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.PrintWriter;
import java.net.Socket;
import java.util.concurrent.Semaphore;

import Database.Reader;

public class Receive implements Runnable {
	Semaphore semaphore;
	private Socket connection;
	Workaround workaround;
	
	public Receive(Socket conn, Semaphore sem, Workaround work){
		this.connection = conn;
		this.semaphore = sem;
		this.workaround = work;
	}

	@Override
	public void run() {
			try {
				semaphore.acquire();
				System.out.println(connection.toString());
				BufferedReader in = new BufferedReader(new InputStreamReader(connection.getInputStream()));
				String userInput;
				userInput = in.readLine();
				System.out.println("userinput: " + userInput);
				Parser parser = new Parser(userInput);
				if (userInput.contains("GET,COMMENT")){
				workaround.setArray();
				workaround.setResultArray(parser.getResultArray());
				}
				else{
				workaround.setResult(parser.getResult());
				}
				connection.close();
				semaphore.release();
				} catch (IOException | InterruptedException e) {e.printStackTrace();}
	}
	
}
