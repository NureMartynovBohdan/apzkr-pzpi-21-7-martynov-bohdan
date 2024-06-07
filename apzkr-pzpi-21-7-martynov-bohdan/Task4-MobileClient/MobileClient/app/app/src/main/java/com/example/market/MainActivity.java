package com.example.market;

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import java.util.HashMap;
import java.util.Map;

public class MainActivity extends AppCompatActivity {

    TextView textViewName, textViewEmail;
    SharedPreferences sharedPreferences;
    Button buttonLogout;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        textViewName = findViewById(R.id.name);
        textViewEmail = findViewById(R.id.email);
        buttonLogout = findViewById(R.id.buttonLogout);
        sharedPreferences = getSharedPreferences("market", MODE_PRIVATE);
        if(sharedPreferences.getString("logged", "false").equals("false")){
            Intent intent = new Intent(getApplicationContext(), Login.class);
            startActivity(intent);
            finish();
        }
        textViewName.setText(sharedPreferences.getString("name", ""));
        textViewEmail.setText(sharedPreferences.getString("email", ""));

        buttonLogout.setOnClickListener(view -> {

            RequestQueue queue = Volley.newRequestQueue(getApplicationContext());
            String url = Url.URL_LOGOUT;

            StringRequest stringRequest = new StringRequest(Request.Method.POST, url,
                    response -> {
                        if (response.equals("success")) {
                            SharedPreferences.Editor editor = sharedPreferences.edit();
                            editor.putString("logged", "");
                            editor.putString("name", "");
                            editor.putString("email", "");
                            editor.putString("apiKey", "");
                            editor.apply();
                            Intent intent = new Intent(getApplicationContext(), Login.class);
                            startActivity(intent);
                            finish();
                        } else {
                            Toast.makeText(MainActivity.this, response, Toast.LENGTH_SHORT).show();
                        }
                    }, error -> {
                error.printStackTrace();
            }){
                protected Map<String, String> getParams(){
                    Map<String, String> paramV = new HashMap<>();
                    paramV.put("email", sharedPreferences.getString("email", ""));
                    paramV.put("apiKey", sharedPreferences.getString("apiKey", ""));
                    return paramV;
                }
            };
            queue.add(stringRequest);
        });
    }
}

