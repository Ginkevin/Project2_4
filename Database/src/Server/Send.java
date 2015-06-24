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
	Workaround workaround;
	
	public Send(Socket conn, Semaphore sem, Workaround work){
		this.connection = conn;
		this.semaphore = sem;
		this.workaround = work;
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
				if (workaround.isArray()){
					out.println(workaround.getResultArray());
					System.out.println("output result: " + workaround.getResultArray().toString());
				}
				else{
					out.println(workaround.getResult());
					System.out.println("output result: " + workaround.getResult());
				}
				connection.close();
				semaphore.release();
				} catch (IOException | InterruptedException e) {e.printStackTrace();}
	}
	
}
