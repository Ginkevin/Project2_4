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
	
	public Receive(Socket conn, Semaphore sem){
		this.connection = conn;
		this.semaphore = sem;
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
				Reader reader = new Reader(Integer.parseInt(userInput));
				Workaround.getWorkaround().setResult(reader.getResult());
				//System.out.println("input result: " + Workaround.getWorkaround().getResult());
				connection.close();
				semaphore.release();
				} catch (IOException | InterruptedException e) {e.printStackTrace();}
	}
	
}
