package Server;

import java.io.IOException;
import java.net.ServerSocket;
import java.net.Socket;
import java.util.concurrent.Semaphore;

public class Host {
	private static final int port = 64005;
	private static Semaphore sem = new Semaphore(2, true);
	 
	
	public Host(){
		Socket connection;
		Socket connection2;
					try {
		ServerSocket server = new ServerSocket(port);
		ServerSocket server2 = new ServerSocket(64006);
		while (true){
			connection = server.accept();
			connection2 = server2.accept();
			Thread receive = new Thread( new Receive(connection, sem));
			receive.start();
			Thread receive2 = new Thread( new Send(connection2, sem));
			receive2.start();
		}
		
					} catch (IOException e) {	e.printStackTrace();}
	}
	
}
