package Server;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.PrintWriter;
import java.net.Socket;
import java.util.concurrent.Semaphore;

import Database.Reader;

public class Send implements Runnable {
	Semaphore semaphore;
	private Socket connection;
	
	public Send(Socket conn, Semaphore sem){
		this.connection = conn;
		this.semaphore = sem;
	}

	@Override
	public void run() {
			try {
				try {
				    Thread.sleep(500);                 //1000 milliseconds is one second.
				} catch(InterruptedException ex) {
				    Thread.currentThread().interrupt();
				}
				semaphore.acquire();
				PrintWriter out = new PrintWriter(connection.getOutputStream(), true);
				out.println(Workaround.getWorkaround().getResult());
				System.out.println("input result: " + Workaround.getWorkaround().getResult());
				connection.close();
				semaphore.release();
				} catch (IOException | InterruptedException e) {e.printStackTrace();}
	}
	
}
