package Server;

public class Workaround {
	static Workaround workaround;
	String result = "default";
	
	public static Workaround getWorkaround(){
		if(workaround == null){
			workaround = new Workaround();
		}
		return workaround;
	}
	
	public void setResult(String res){
		this.result = res;
	}
	
	public String getResult(){
		return this.result;
	}
}
