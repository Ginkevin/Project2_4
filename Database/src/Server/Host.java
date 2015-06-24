package Server;

import java.io.IOException;
import java.net.ServerSocket;
import java.net.Socket;
import java.util.concurrent.Semaphore;

public class Host {
	private static final int port = 64005;
	private static Semaphore sem = new Semaphore(2, true);
	 
	
	public Host(){
		Socket connection_receive;
		Socket connection_send;
					try {
		ServerSocket server_receive = new ServerSocket(port);
		ServerSocket server_send = new ServerSocket(64006);
		while (true){
			connection_receive = server_receive.accept();
			connection_send = server_send.accept();
			Workaround workaround = new Workaround();
			Thread receive = new Thread( new Receive(connection_receive, sem, workaround));
			receive.start();
			Thread send = new Thread( new Send(connection_send, sem, workaround));
			send.start();
		}
		
					} catch (IOException e) {	e.printStackTrace();}
	}
	
}
